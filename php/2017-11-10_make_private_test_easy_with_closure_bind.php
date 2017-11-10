<?php
/*
Closure::bindを使って、privateなテストを楽する。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

class User
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    private function getName()
    {
        return $this->name;
    }
}

Closure::bind(function() {
    $user = new User('mike');
    assert('mike' === $user->name);
    assert('mike' === $user->getName());
}, null, User::class)->__invoke();
