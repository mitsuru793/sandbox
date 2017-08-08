<?php
/*
laravelのCollection->keyByでidで要素を取得できるようにする。

検索値は連想配列のkeyにすると速い。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;
use Illuminate\Support\Collection;

$rows = [
    (object)['id' => 15, 'name' => 'Mike'],
    (object)['id' => 20, 'name' => 'Jane'],
];

$models = collect($rows)->keyBy('id');
assert($models[15]->name === 'Mike');
assert($models[20]->name === 'Jane');

dump($models->all());
