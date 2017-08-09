<?php
/*
インスタンスメソッドと同名をクラスメソッドとして呼び出すと、__callStaticを定義してもDeprecatedになる。
*/

require_once __DIR__ . '/vendor/autoload.php';

class P
{
    public static function __callStatic(string $method, array $args)
    {
        return (new static)->$method(...$args);
    }

    public function publicMethod()
    {
        return 'public';
    }

    protected function protectedMethod()
    {
        return 'protected';
    }

    private function privateMethod()
    {
        return 'private';
    }
}

try {
    // PHP Deprecated:  Non-static method P::publicMethod() should not be called statically
    // P::publicMethod();
} catch (Error $e) {

}

assert(P::protectedMethod() === 'protected');
assert(P::privateMethod() === 'private');
