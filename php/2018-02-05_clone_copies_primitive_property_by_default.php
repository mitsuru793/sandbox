<?php
/*
デフォルトでcloneはプリミティブなプロパティをコピーしてくれる。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

class User
{
    public $name;
    public $age;
}

// cloneしないので、同じ値の参照を持っている
$user1 = new User;
$user1->name = 'mike';

$user2 = $user1;
$user2->name = 'jane';

assert('jane' === $user1->name);
assert('jane' === $user2->name);

// 全てのプロパティがコピーされる
$user1 = new User;
$user1->name = 'mike';
$user1->age = 20;

$user2 = clone $user1;
$user2->name = 'jane';

assert('mike' === $user1->name);
assert('jane' === $user2->name);

dump($user2);

// 値をセットしない場合は、初期値が入っている。
$user1 = new User;
$user1->name = 'mike';

$user1 = new User;
$user1->name = 'mike';

$user2 = clone $user1;

assert(is_null($user2->age));

// privateのプロパティも自動でコピーされる

class User2
{
    private $name;
    private $age;

    public function __construct($name, $age)
    {
        $this->name = $name;
        $this->age = $age;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function name()
    {
        return $this->name;
    }
}

$user1 = new User2('mike', 15);
$user2 = clone $user1;
$user2->setName('jane');

assert('mike' === $user1->name());
assert('jane' === $user2->name());

dump($user2);
