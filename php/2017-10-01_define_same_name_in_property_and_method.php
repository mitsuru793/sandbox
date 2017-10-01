<?php
/*
同じプロパティ名とメソッド名を定義できるので、使い分けができる。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

class User
{
    public $name = 'mike';

    public function name()
    {
        return 'jane';
    }
}

$user = new User;
assert('mike' === $user->name);
assert('jane' === $user->name());
