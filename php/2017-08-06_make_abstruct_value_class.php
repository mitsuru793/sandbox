<?php
/*
Valueオブジェクトの抽象クラスを作る

同じstringでも、Text, Nameとラップして型を示す事が可能。
メソッドを持たせることも出来る。
Value::of($value)としか生成させないようにして、見分けをつける。
*/
require_once __DIR__ . '/vendor/autoload.php';

function run()
{
    try {
        new Name('Mike');
        assert(false);
    } catch (Error $e) {
        assert($e->getMessage() ===
            'Call to protected Name::__construct() from invalid context');
    }
    assert(Name::of('Mike') instanceof Name);
    assert((string)Name::of('Mike') === 'Mike');
}

/**
 * バリューオブジェクトを表す。
 * スカラ型のラッパークラスに近い。
 *
 * 外側からはOfメソッドでしか生成できないので、
 * ValueObjectとそれ以外の見分けがつく。
 *
 * ※ constructは子クラスでprotectedにする必要がある。強制はできない。
 *   (constructでタイプヒントを扱えるようにするため。)
 */
abstract class Value implements \JsonSerializable
{
    protected $value;

    public static function of($value)
    {
        return new static($value);
    }

    public function isEmpty() : bool
    {
        return empty($this->value);
    }

    public function isNotEmpty() : bool
    {
        return !empty($this->value);
    }

    public function jsonSerialize()
    {
        return $this->value;
    }
}

class Name extends Value
{
    protected function __construct(string $name)
    {
        $this->value = $name;
    }

    public function __toString()
    {
        return $this->value;
    }
}

run();
