<?php
/*
json_encodeで__toStringは呼ばれない

新しく中身をstringにキャストしながら、配列を作り直すかJsonSerializableを実装しておく。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

class User
{
    public function __toString()
    {
        return 'Mike';
    }
}

$mike = new User;
$array = [
    'user' => $mike,
];
assert('{"user":{}}' === json_encode($array));

class Country implements JsonSerializable
{
    public function jsonSerialize()
    {
        return 'Japan';
    }
}

$japan = new Country;
$array = [
    'country' => $japan,
];
assert('{"country":"Japan"}' === json_encode($array));
