<?php
/*
laravelのCollectionは、配列のkey名を維持する。

keyに数字が使われている場合は、数値に変わる。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

function run()
{
    $array = [
        'name' => 'Mike',
        'age' => 13,
    ];
    $actual = map($array);
    $expected = [
        'name' => '@Mike@',
        'age' => '@13@',
    ];
    assert($expected === $actual);

    $array = [
        '0' => 'Mike',
        '100' => 13,
    ];
    $actual = map($array);
    $expected = [
        0 => '@Mike@',
        100 => '@13@',
    ];
    assert($expected === $actual);

    $array = [
        0 => 'Mike',
        100 => 13,
    ];
    $result = map($array);
    assert($expected === $actual);
}

function map(array $array) : array
{
    return collect($array)->map(function ($value) {
        return "@$value@";
    })->all();
}

run();
