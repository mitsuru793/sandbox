<?php
/*
カラムごとにレコードの要素がある配列を、1レコード1要素に変換する。

formのinputで`users[0][name]`ではなく`name[]`としか書けない場合を想定

```
['name' => ['Adrain Cruickshank', ...], 'age' => [33, ...]]
[['name' => ['Adrain Cruickshank'], 'age' => 33], ...]
```
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

$inputs = [
  'name' => [
    'Adrain Cruickshank',
    'Makayla Waelchi IV',
    'Prof. Lea Larson',
    'Benedict Schimmel DVM',
    'Mr. Coty Jaskolski',
    'Merle Conner',
  ],
  'age' => [
    84,
    65,
    87,
    46,
    45,
    82,
  ],
];

// reduceはkeyを取れないめ、先に生成しておく。
$columns = array_keys($inputs);
$records = array_reduce($inputs, function ($records, $values) use (&$columns) {
    $column = array_shift($columns);
    foreach ($values as $i => $val) {
        $records[$i][$column] = $val;
    }
    return $records;
});
dump($records);
