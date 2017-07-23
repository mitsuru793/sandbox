<?php
/*
nikic/PHP-Parserで特定のNodeを集めるVisitorを作成する。

集めるNodeごとにVisitorを作る必要がなくなる。
*/
require_once __DIR__ . '/vendor/autoload.php';

use PhpParser\Error;
use PhpParser\ParserFactory;
use PhpParser\NodeTraverser;
use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

const CODE = <<<'EOF'
<?php
func();
class Test
{
    public $prop;
    public function m1()
    {
        func();
        $tmp = function () {
            func();
        };
    }
}
EOF;

function run()
{
    $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
    try {
        $stmts = $parser->parse(CODE);
        $stmts = filter($stmts,
            [Node\Expr\FuncCall::class, Node\Stmt\PropertyProperty::class]);

        assert(4 == count($stmts));

        assert(3 == collect($stmts)->filter(function ($node) {
            return $node instanceof Node\Expr\FuncCall;
        })->count());

        assert(1 == collect($stmts)->filter(function ($node) {
            return $node instanceof Node\Stmt\PropertyProperty;
        })->count());

        dump($stmts);
    } catch (Error $e) {
        echo 'Parse Error: ', $e->getMessage();
    }
}

function filter(array $stmts, $collectTypes)
{
    $traverser = new NodeTraverser;
    $traverser->addVisitor(new CollectNodeVisitor($collectTypes));
    return $traverser->traverse($stmts);
}

class CollectNodeVisitor extends NodeVisitorAbstract
{
    private $collectTypes;
    private $collectNodes;

    /**
     * @param string|array $collectTypes 探すNodeType
     * @param bool $deep $collectTypesが見つかった時に、さらにノードを追うか。
     */
    public function __construct($collectTypes, $deep = true)
    {
        $this->deep = $deep;
        if (is_null($collectTypes)) {
            throw new InvalidArgumentException('$collectTypes must not be null.');
        }
        if (is_string($collectTypes)) {
            $collectTypes = [$collectTypes];
        }
        $this->collectTypes = $collectTypes;
    }

    public function beforeTraverse(array $nodes)
    {
        $this->collectNodes = [];
    }

    public function enterNode(Node $node)
    {
        if ($this->instanceofAny($node, $this->collectTypes)) {
            $this->collectNodes[] = $node;
            if (!$this->deep) {
                return NodeTraverser::DONT_TRAVERSE_CHILDREN;
            }
        }
    }

    public function afterTraverse(array $nodes) {
        return $this->collectNodes;
    }

    private function instanceofAny($obj, array $types) : bool
    {
        foreach ($types as $type) {
            if ($obj instanceof $type) {
                return true;
            }
        }
        return false;
    }
}
run();
