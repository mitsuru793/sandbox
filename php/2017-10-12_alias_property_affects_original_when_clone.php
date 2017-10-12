<?php
/*
エイリアスのプロパティはcloneすると値ではなく、参照をコピーするので元のオブジェクトに影響する。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

class User
{
    public $name;
    private $namae;

    public $age;

    public function __construct(Name $name, Age $age)
    {
        // エイリアスを使用
        $this->namae = &$this->name;
        $this->namae = $name;

        // エイリアスを使わない
        $this->age = $age;
    }

    public function withName(Name $name): self
    {
        $new = clone $this;
        $new->namae = $name;
        return $new;
    }

    public function withAge(Age $age): self
    {
        $new = clone $this;
        $new->age = $age;
        return $new;
    }
}

trait Value
{
    public $value;
    private function __construct($value)
    {
        $this->value = $value;
    }

    public static function of($value)
    {
        return new static($value);
    }
}

class Name
{
    use Value;
}

class Age
{
    use Value;
}

$user = new User(Name::of('mike'), Age::of(20));
assert('mike' === $user->name->value);

// cloneで参照をコピーしているので、元のオブジェクトに影響がある。
$user2 = $user->withName(Name::of('jane'));
assert('jane' === $user->name->value);
assert('jane' === $user2->name->value);
assert($user->name === $user2->name);

// エイリアスを使っていないので、値自体をcloneしている。
$user3 = $user->withAge(Age::of(30));
assert(20 === $user2->age->value);
assert(30 === $user3->age->value);
assert($user2->age !== $user3->age);
