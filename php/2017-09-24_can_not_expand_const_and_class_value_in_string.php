<?php
/*
定数とクラス変数は文字列の中で展開できない。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

class Hoge
{
    const MY_CONST = 'CONST VALUE';
    public static $myStatic = 'static value';
    public $myInsProp = 'ins prop value';
}

// 定数は式として認識されない
assert('[{Hoge::MY_CONST}]' === "[{Hoge::MY_CONST}]");

// 式として認識されるがクラスが無視される。
// Notice: Undefined variable: myStatic
// assert('[static value]' === "[{Hoge::$myStatic}]");

$hoge = new Hoge;
assert('[ins prop value]' === "[{$hoge->myInsProp}]");
