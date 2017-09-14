<?php
/*
同じクラス変数名を子クラスで再定義しないと、親と他の子クラス全体で共有される。

親が抽象クラスで親とクラス変数を共有しない場合は、親に定義しない方が良いと思う。
親では定義をコメントアウトして、子クラスで定義するようにコメントしておくと良い。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

// オーバーライドしない
class P1
{
     public static $prop;
}

class A1 extends P1
{
}

class A2 extends P1
{
}

assert(is_null(P1::$prop));
assert(is_null(A1::$prop));
assert(is_null(A2::$prop));

A1::$prop = 'c1';
assert('c1' === P1::$prop);
assert('c1' === A1::$prop);
assert('c1' === A2::$prop);

A2::$prop = 'c2';
assert('c2' === P1::$prop);
assert('c2' === A1::$prop);
assert('c2' === A2::$prop);

// オーバーライドする
class P2
{
    public static $prop;
}

class B1 extends P2
{
    public static $prop;
}

class B2 extends P2
{
    public static $prop;
}

assert(is_null(P2::$prop));
assert(is_null(B1::$prop));
assert(is_null(B2::$prop));

B1::$prop = 'c1';
assert(is_null(P2::$prop));
assert('c1' === B1::$prop);
assert(is_null(B2::$prop));

B2::$prop = 'c2';
assert(is_null(P2::$prop));
assert('c1' === B1::$prop);
assert('c2' === B2::$prop);
