<?php
/*
配列のkeyをリネームする
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

function array_rename_key(array &$array, array $renames)
{
    foreach ($renames as $old => $new) {
        if (!array_key_exists($old, $array)) {
            continue;
        }
        $array[$new] = $array[$old];
        unset($array[$old]);
    }
}

$user = [
    'id' => 1,
    'name' => 'Mike',
    'age' => null,
];
array_rename_key($user, [
    'id' => 'num',
    'name' => 'namae',
    'age' => 'toshi',
    'no' => 'invalid',
]);
dump($user);
