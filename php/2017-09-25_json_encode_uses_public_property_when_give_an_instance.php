<?php
/*
json_encodeにインスタンスを渡すとpublicプロパティが使用される。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

class User
{
    private $id;
    public $name;
    public $age;

    public function __construct(int $id, string $name, int $age)
    {
        $this->id = $id;
        $this->name = $name;
        $this->age = $age;
    }
}

$user = new User(1, 'mike', 12);
$json = json_encode($user);
assert('{"name":"mike","age":12}' === $json);
