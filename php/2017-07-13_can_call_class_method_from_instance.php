<?php
/*
インスタンスからクラスメソッドを呼び出せるが、インスタンスメソッドをクラスメソッドとしては呼び出すのは非推奨。
*/

class A
{
    public static function classMethod()
    {
        return 'called';
    }

    public function instanceMethod()
    {
        return self::classMethod();
    }
}

$a = new A;
assert($a::classMethod() === 'called');
assert($a::instanceMethod() === 'called');

error_reporting(E_ALL);
$a::classMethod();

// PHP Deprecated:  Non-static method A::instanceMethod() should not be called statically
// $a::instanceMethod();
