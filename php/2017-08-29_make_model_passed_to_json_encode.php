<?php
/*
モデルをjson_encodeに渡せるようにする。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

class User implements JsonSerializable
{
    private $data = [
        'name' => 'mike',
        'age' => 21,
    ];

    public function jsonSerialize()
    {
        return $this->data;
    }
}

$user = new User;
assert(json_encode($user) === '{"name":"mike","age":21}');
