<?php
/*
三項演算子の戻り値にメソッドチェーンにする。

()で囲めばwithは必要ないが、読みやすさを考慮しているかもしれない。
*/

// https://github.com/tightenco/collect/blob/master/src/Illuminate/Support/helpers.php
function with($object)
{
    return $object;
}

class Person
{
    public $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function name() : string
    {
        return $this->name;
    }
}

$res = with(true ? new Person('mike') : new Person('jane'))
    ->name();
assert($res === 'mike');

$res = (false ? new Person('mike') : new Person('jane'))
    ->name();
assert($res === 'jane');
