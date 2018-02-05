<?php
/*
引数が配列の場合はunsetしても副作用はないが、objectだと副作用がある。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

function removeArrayKey($data, $key)
{
    unset($data[$key]);
    return $data;
}

$userArray = ['name' => 'mike', 'age' => 20];
$userArrayWithoutAge = removeArrayKey($userArray, 'age');
assert($userArray['age'] === 20);
assert(!array_key_exists('age', $userArrayWithoutAge));

function removeObjProp($data, $key)
{
    unset($data->{$key});
    return $data;
}

$userObj = (object)['name' => 'mike', 'age' => 20];
assert($userObj->age === 20);

$userObjWithoutAge = removeObjProp($userObj, 'age');
assert($userObj->age === 20);
assert(!property_exists($userObjWithoutAge, 'age'));
