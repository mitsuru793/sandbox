<?php
/*
get_class_methodsはインスタンスとクラスメソッドの両方を返す。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

class User
{
    public function staticM() {}
    public function instanceM() {}
}

$expected = ['staticM', 'instanceM'];
assert($expected === get_class_methods('User'));
assert($expected === get_class_methods(User::class));
assert($expected === get_class_methods(new User));

// インスタンスからクラスメソッドを呼び出してもエラーにならない。
$user = new User;
$user->staticM();
