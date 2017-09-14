<?php
/*
配列とstdClassを相互に再帰的に変換する関数を作る
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

function arrayToObject(array $array)
{
    $obj = (object)$array;
    foreach ($obj as &$prop) {
        if (is_array($prop)) {
            $prop = arrayToObject($prop);
        }
    }
    return $obj;
}

function objectToArray($object)
{
    if (!is_object($object)) {
        return $object;
    }

    $array = (array)$object;
    foreach ($array as &$value) {
        if (is_object($value)) {
            $value = objectToArray($value);
        }
    }
    return $array;
}

$array = [
    'taro' => [
        'age' => 19,
        'from' => 'Japan',
    ],
    'mike' => [
        'age' => 21,
        'from' => 'Australia',
    ],
];

$object = (object)[
    'taro' => (object)[
        'age' => 19,
        'from' => 'Japan',
    ],
    'mike' => (object)[
        'age' => 21,
        'from' => 'Australia',
    ],
];

// objectだとインスタンスのidが違うと失敗するので厳密に比較しない
assert($object == arrayToObject($array));
assert($array === objectToArray($object));
