<?php
/*
compactに変数名を渡すと、[変数名 => 変数値]に変換する。
*/

$people = [];

$people[] = [
    'name' => 'taro',
    'age' => 19,
];

$name = 'taro';
$age = 19;
$people[] = compact('name', 'age');
print_r($people);
