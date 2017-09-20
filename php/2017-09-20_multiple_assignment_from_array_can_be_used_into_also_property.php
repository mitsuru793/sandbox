<?php
/*
配列からの多重代入は、プロパティも指定できる。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

class User
{
    public $id;
    public $name;

    public static function fromJoinedWithUnderscore(string $str) : self
    {
        $user = new static;
        [$user->id, $user->name] = explode('_', $str);
        return $user;
    }
}

$user = User::fromJoinedWithUnderscore('1_mike');
assert('1' === $user->id);
assert('mike' === $user->name);
