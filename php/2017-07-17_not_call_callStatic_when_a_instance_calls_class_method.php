<?php
/*
インスタンスにクラスメソッドを呼び出しても、__callStaticは呼ばれない。
*/

class P1
{
    public static $name = 'man';

    public static function hello()
    {
        return 'hello';
    }
}

$p = new P1;
assert($p->hello() === 'hello');

assert(P1::$name === 'man');

// Undefined variable: name
// $p->$name();

class P2
{
    public static function __callStatic($name, $arguments)
    {
        return "$name is called.";
    }

    public static function say()
    {
        return 'say';
    }
}

$p = new P2;
assert($p->say() === 'say');
assert($p::hello() === 'hello is called.');
