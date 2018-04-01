<?php
/*
ミドルウェアで正規表現を重ねる

ANDを示すスペースをORに変換します。クオートで囲んでいる場合は無視します。
*/
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use League\Route\Middleware\StackAwareInterface;
use League\Route\Middleware\StackAwareTrait;

function main()
{
    $s = 'a b　c OR d AND "1 2 AND ３" "4"';
    $q = new Query();
    $res = $q->convertAndSpaceToOr($s);
    dump($res);
    // "a OR b OR c OR OR OR d OR AND OR "1 OR 2 OR AND OR ３" OR "4""
}

class Query
{
    // \sでは全角スペースがヒットしない
    private const BLANK = '[ 　]';

    /**
     * BNDを示すスペースを、OR演算子に変換する。
     */
    public function convertAndSpaceToOr(string $query): string
    {
        $blank = self::BLANK;
        $middlewares = [
            new ReplaceTempolary("/{$blank}? (\".+?\") {$blank}?/x", '___QUOTE___'),
            new ReplaceTempolary("/{$blank}?(OR|AND){$blank}?/", '___OPERATOR___'),
            function (string $str, $next) use ($blank) {
                return preg_replace("/{$blank}+/", ' OR ', $str);
            }
        ];
        $execChain = (new ExecutionChain)->middlewares($middlewares);
        return $execChain->execute($query);
    }
}

final class ReplaceTempolary
{
    /** @var string */
    private $targetRe;

    /** @var string */
    private $placeHolder;

    public function __construct(string $targetRe, string $placeHolder)
    {
        $this->targetRe = $targetRe;
        $this->placeHolder = $placeHolder;
    }

    public function __invoke(string $str, $next)
    {
        preg_match_all($this->targetRe, $str, $matches, PREG_SET_ORDER);
        $replaced = preg_replace($this->targetRe, $this->placeHolder, $str);
        $replaced = $next($replaced);

        foreach ($matches as $quote) {
            $replaced = preg_replace("/{$this->placeHolder}/", " $quote[1] ", $this->replaced, 1);
        }

        return $replaced;
    }
}

final class ExecutionChain implements StackAwareInterface
{
    use StackAwareTrait;

    /**
     * Build and execute the chain.
     *
     * @param stdClass $itemData
     * @return mixed $item
     */
    public function execute($itemData)
    {
        $chain = $this->buildExecutionChain();
        return $chain($itemData);
    }

    /**
     * Build an execution chain.
     *
     * @return callable
     */
    protected function buildExecutionChain()
    {
        $stack = $this->getMiddlewareStack();
        $next = function ($itemData) {
            return null;
        };
        foreach ($stack as $middleware) {
            $next = function ($itemData) use ($middleware, $next) {
                return $middleware($itemData, $next);
            };
        }
        return $next;
    }
}

main();
