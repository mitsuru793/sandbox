<?php
/*
tightenco/collectのArr::collapseを読む
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

function collapse($array)
{
    $results = [];

    foreach ($array as $values) {
        if ($values instanceof Collection) {
            $values = $values->all();
        } elseif (! is_array($values)) {
            // 配列以外の要素は除去される
            continue;
        }

        // 第1階層までしか展開されないが、全階層は値の上書きが行われる。
        $results = array_merge($results, $values);
    }

    return $results;
}

assert([] === collapse([1, 2 ,3]));

assert([1, 2, 3] === collapse([ [1], [2 ,3], 4 ]));

assert([
    1,
    2,
    [
        3, 4,
        [5, 6]
    ]
] === collapse([
    [1],
    [
        2,
        [
            3, 4,
            [5, 6]
        ]
    ]
]));
