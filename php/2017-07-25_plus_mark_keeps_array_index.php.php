<?php
/*
配列の結合にarray_mergeを使うと、添字が壊れる時は+を使うと良いこともある。

+を使うと重複したkeyの値は上書きされない。添字を維持するarray_mergeのような関数はない？

配列のkeyにid(数字)を使っている時にarray_mergeを使うと、0から振り直されるため+をつかう。
idはユニークのため、+で重複を許さないのも有効である。
*/

function assertEqual($a, $b)
{
    assert($a === $b);
}

$yamada = [
    'name' => 'Yamada',
];

$jane = [
    'name' => 'Jane',
    'age' => 30,
];

// + は同じKeyの場合は後ろの配列で上書きしない
assertEqual($yamada + $jane, ['name' => 'Yamada', 'age' => 30]);
assertEqual($jane + $yamada, ['name' => 'Jane', 'age' => 30]);

// array_merge は同じKeyの場合は後ろの配列で上書きする
assertEqual(array_merge($yamada, $jane), ['name' => 'Jane', 'age' => 30]);
assertEqual(array_merge($jane, $yamada), ['name' => 'Yamada', 'age' => 30]);

$yamada = ['Yamada'];
$jane = ['Jane', 30];

// 通常の配列も自動で連番のkeyが振られるので、連想配列である。
assertEqual($yamada + $jane, ['Yamada', 30]);
assertEqual($jane + $yamada, ['Jane', 30]);

// array_mergeはkeyが数字の場合は、同じkeyでも上書きせずに追加する。
assertEqual(array_merge($yamada, $jane), ['Yamada', 'Jane', 30]);
assertEqual(array_merge($jane, $yamada), ['Jane', 30, 'Yamada']);

// array_mergeはkeyが添字の場合は、維持せずに0から振り直す。
$eng = ['2' => 'two', '5' => 'five'];
$num = ['2' => 2, '5' => 5];
assertEqual(array_merge($eng, $num), [
    0 => 'two',
    1 => 'five',
    2 => 2,
    3 => 5,
]);

assertEqual(array_merge($num, $eng), [
    0 => 2,
    1 => 5,
    2 => 'two',
    3 => 'five',
]);
