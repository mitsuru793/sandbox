<?php
/*
array_mapでkeyを指定できないためforeachを使う
*/
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

$users = [
    (object)[
        'id' => 1,
        'name' => 'Mike',
        'sex' => 'man',
    ],
    (object)[
        'id' => 2,
        'name' => 'Jane',
        'sex' => 'woman',
    ],
];

$res = array_map(function ($user) {
    return [$user->name => $user->sex];
}, $users);
dump($res);

$res = [];
foreach ($users as $user) {
    $res[$user->sex] = $user->name;
}
dump($res);
