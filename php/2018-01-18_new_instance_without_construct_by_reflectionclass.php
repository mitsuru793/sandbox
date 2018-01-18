<?php
/*
ReflectionClassを使ったコンストラクタを呼び出さずにインスタンスを生成

ReflectionClassを使ってもprivateのコンストラクタにはアクセス出来ない。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

class User
{
    public function __construct($name, $age)
    {
        puts("name: $name, age: $age");
    }
}

(new ReflectionClass(User::class))->newInstance('mike', 19);
(new ReflectionClass(User::class))->newInstanceArgs(['mike', 19]);
(new ReflectionClass(User::class))->newInstanceWithoutConstructor(['mike', 19]);

class Country
{
    private function __construct($name, $people)
    {
        puts("name: $name, age: $people");
    }
}

// (new ReflectionClass(Country::class))->newInstance('Japan', 11000);
// (new ReflectionClass(Country::class))->newInstanceArgs(['Japan', 11000]);
(new ReflectionClass(Country::class))->newInstanceWithoutConstructor();

// コンストラクタを呼び出せても、インスタンスを取得できない。
$reflection = new ReflectionClass(Country::class);
$constructor = $reflection->getMethod('__construct');
$constructor->setAccessible(true);

$country = $reflection->newInstanceWithoutConstructor();
assert(null === $constructor->invoke($country, 'Australia', 2000));
