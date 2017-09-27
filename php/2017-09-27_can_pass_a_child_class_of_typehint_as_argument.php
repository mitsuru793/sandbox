<?php
/*
タイプヒントの子クラスを引数として渡すことは可能
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

class P {}
class C extends P {}

class User
{
    public function hi(P $to) {}
}

$user = new User;
$user->hi(new P);
$user->hi(new C);
