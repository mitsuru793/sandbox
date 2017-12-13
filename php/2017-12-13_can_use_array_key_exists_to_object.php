<?php
/*
array_key_existsはオブジェクトにも使える
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

$o = new stdClass;
$o->name = 'mike';

class User
{
    public $name = 'jane';
}
$user = new User;

assert(true === array_key_exists('name', $o));
assert(false === array_key_exists('age', $o));
assert(true === array_key_exists('name', $user));
assert(false === array_key_exists('age', $user));
