<?php
/*
privateプロパティから値を取得するリフレクションのヘルパー関数を作成
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

function valueFromProperty($object, string $propName)
{
    $reflection = new ReflectionClass($object);
    $prop = $reflection->getProperty($propName);
    $prop->setAccessible(true);
    return $prop->getValue($object);
}

class P
{
    private $prop = 'value';
}

$p = new P;
assert('value' === valueFromProperty($p, 'prop'));
