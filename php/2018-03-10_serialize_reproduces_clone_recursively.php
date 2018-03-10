<?php
/*
シリアライズで再帰的なcloneを再現する
*/
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

$data = (object)[
    'user' => (object)[
        'name' => 'mike'
    ]
];

$other = clone $data;

// userが参照しているオブジェクトの参照値まではcloneされていない
$other->user->name = 'jane';
assert($data->user->name === 'jane');
assert($other->user->name === 'jane');

// userの参照値はcloneされている
$other->user = (object)['name' => 'nicole'];
assert($data->user->name === 'jane');
assert($other->user->name === 'nicole');

// 再帰的にコピーするため、シリアライズからデータを生成する。
$data = (object)[
    'user' => (object)[
        'name' => 'mike'
    ]
];
$other = unserialize(serialize($data));

$other->user->name = 'jane';
assert($data->user->name === 'mike');
assert($other->user->name === 'jane');
