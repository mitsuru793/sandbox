<?php
/*
文字列の変数展開でメソッドを呼び出すことができる
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

class User
{
    public function name(): string
    {
        return 'mike';
    }
}

$user = new User;
assert("@{$user->name()}" === '@mike');
