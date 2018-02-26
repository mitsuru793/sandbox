<?php
/*
array_columnはobjectにも使える
*/
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

$users = [
    [
        'id' => 1,
        'name' => 'mike',
    ],
    [
        'id' => 2,
        'name' => 'jane',
    ],
    [
        'id' => 3,
        'name' => 'oliver',
    ],
];

assert(array_column($users, 'name') === [
    0 => "mike",
    1 => "jane",
    2 => "oliver",
]);

$objectUsers = array_map(function($user) {
    return (object)$user;
}, $users);

assert(array_column($objectUsers, 'id') === [
    0 => 1,
    1 => 2,
    2 => 3,
]);
