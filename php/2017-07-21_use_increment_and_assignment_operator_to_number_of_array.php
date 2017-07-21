<?php
/*
配列の要素である数値にインクリメント、代入演算子が使える。
*/

$array = [
    'total' => 0,
];

$array['total']++;
assert($array['total'] === 1);

$array['total'] += 2;
assert($array['total'] === 3);
