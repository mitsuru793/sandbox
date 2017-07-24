<?php
/*
laravelのcollectionのHigher Order Messageで、ゲッターを通して集めた値にフィルタリングをかける。
*/
require __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Collection;

class Person
{
    public $name;
    public function __construct(?string $name)
    {
        $this->name = $name;
    }
    public function getName() : ?string
    {
        return $this->name;
    }
}
$people = new Collection(
    [new Person('Yamada'), new Person(null), new Person(''), new Person('Jane')]
);
// filterはkeyを維持するので、valuesでindexを0から振り直す。
$names = $people->map->getName()->filter()->values()->all();
assert($names === ['Yamada', 'Jane']);
