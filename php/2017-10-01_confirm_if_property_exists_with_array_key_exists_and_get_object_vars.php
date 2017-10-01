<?php
/*
array_key_existsを$thisに使う前に、get_object_varsを使ってプロパティの有無を確認する。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

class User
{
    protected $age;

    public function alwaysNotHas($name)
    {
        return array_key_exists($name, $this);
    }

    public function has($name)
    {
        return array_key_exists($name, get_object_vars($this));
    }
}

$user = new User;
assert(false === $user->alwaysNotHas('age'));
assert($user->has('age'));
