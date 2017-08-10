<?php
/*
laravelのcollectにはarrayだけでなく、Collectionを混ぜても良い。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

// Collectionをcollectに渡しても問題ない。
$nums = collect([1,2,3]);
assert(collect($nums)->all() === [1,2,3]);

$users = collect([
    [
        'id' => 1,
        'name' => 'Mike',
    ],
    [
        'id' => 2,
        'name' => 'Jane',
    ],
]);
$json = collect([
    'success' => true,
    'users' => $users
]);
dump($json->toArray());
dump($json->toJson());
