<?php
/*
外側だけでなく、メソッド内で自身の存在しないプロパティにアクセスした時にも__getは呼び出される。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

class User
{
    public function __get(string $name)
    {
        return "$name is getter";
    }

    public function introduce() : string
    {
        return "Hi, {$this->userName}";
    }
}

$user = new User;
assert('Hi, userName is getter' === $user->introduce());
