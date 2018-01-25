<?php
/*
文字展開の波括弧を二重にすると、変数名を動的に解決できる。
*/

require_once __DIR__ . '/vendor/autoload.php';

use Mihaeu\HtmlFormatter;
use function Lib\puts;

class Hoge
{
    public const PUB_CONST = 'CONST_VAL';
    public static $pubProp = 'propVal';

    public static function testConst1()
    {
        return "PUB_CONST = {self::PUB_CONST}";
    }

    public static function testConst2()
    {
        // PHP Notice:  Undefined variable: CONST_VAL
        return "PUB_CONST = {${self::PUB_CONST}}";
    }

    public static function testConst3()
    {
        $CONST_VAL = 'hello';
        return "{${self::PUB_CONST}}";
    }

    public static function testProp1()
    {
        // Notice: Undefined variable: propVal
        return "pubProp = {${self::$pubProp}}";
    }

    public static function testProp2()
    {
        $propVal = 'world';
        return "{${self::$pubProp}}";
    }
}

assert(Hoge::testConst1() === 'PUB_CONST = {self::PUB_CONST}');
// Noticeが出る
// assert(Hoge::testConst2() === 'PUB_CONST = ');
// assert(Hoge::testProp1() === 'pubProp = ');

assert(Hoge::testConst3() === 'hello');
assert(Hoge::testProp2() === 'world');
