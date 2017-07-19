<?php
/*
__callStaticを定義していても、インスタンスメソッドをクラスメソッドとして呼び出すと警告される。
*/

class P
{
    public static function classM()
    {
        return 'class called';
    }

    public function instanceM()
    {
        return 'instance called';
    }
}

// インスタンスメソッドをクラスメソッドとして呼び出すとエラーが出る。
// インスタンスを生成していないから、インスタンスにはアクセスできないのが理由。
// Deprecated:  Non-static method P::instanceM() should not be called statically
// P::instanceM();

// クラスメソッドはインスタンスからも呼び出せる。
// 全インスタンスでクラスメソッドは共有されているのでアクセスできる。
$p = new P;
assert($p->classM() === 'class called');

class Person
{
    public function say()
    {
        return 'Hi';
    }

    public static function __callStatic($name, $arguments)
    {
        return $name;
    }
}

// インスタンスメソッドとして定義済みの場合は__callStaticを定義していても警告出る。
// PHP Deprecated:  Non-static method Person::say() should not be called statically
assert(@Person::say() === 'Hi'); // 警告を抑制している。

// 未定義のため警告は出ない。
assert(Person::hello() === 'hello');
