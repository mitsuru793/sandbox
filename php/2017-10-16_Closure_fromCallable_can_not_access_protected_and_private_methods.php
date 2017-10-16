<?php
/*
Closure::fromCallableを使っても、protected/privateメソッドにアクセスできない。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

class MyClass
{
    public function pubMethod() {}
    protected function proMethod() {}
    private function priMethod() {}
}

$o = new MyClass;
$o->pubMethod();
// Fatal Error
// $o->proMethod();
// $o->priMethod();

Closure::fromCallable([$o, 'pubMethod']);
// Closure::fromCallable([$o, 'proMethod']);
// Closure::fromCallable([$o, 'priMethod']);
