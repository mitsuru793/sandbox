<?php
/*
get_object_varsの戻り値で、値がオブジェクトのプロパティの中身を変えると、元のオブジェクトまで変わる。

オブジェクトの場合は参照が渡っているため。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

class Age
{
    public $value;

    public function __construct(int $name)
    {
        $this->value = $name;
    }
}

class User
{
    public $name;
    public $age;
    private $nenrei;

    public function __construct(string $name , int $age)
    {
        $this->name = $name;
        // 内部のみでプロパティのエイリアスを使うことを想定。
        $this->nenrei = &$this->age;
        $this->nenrei = $age;
    }
}

$user = new User('mike', 13);

$vars = get_object_vars($user);
assert(is_array($vars));

dump($user);
// User {#3
//   +name: "mike"
//   +age: &1 13
//   -nenrei: &1 13
// }

$vars['age'] = 15;
dump($user);
// User {#3
//   +name: "mike"
//   +age: &1 15
//   -nenrei: &1 15
// }
