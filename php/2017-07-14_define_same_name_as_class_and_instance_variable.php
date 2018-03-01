<?php
/*
同名のクラス・インスタンス変数は定義する場合は、Noticeをもみ消す。

インスタンス変数がない場合は、同名のクラス変数がないかを探す。
$o::$static_propという方法でアクセスも出来るが、共用変数なのでどのインスタンスから見ても同じ。
わざわざクラス変数からアクセスする必要はない。
*/

class Person
{
    public static $name = 'Mike';
}


$p = new Person;

// PHP Notice:  Accessing static property Person::$name as non static
// PHP Notice:  Undefined property: Person::$name
// $p->name;

// PHP Fatal error:  Uncaught Error: Undefined class constant 'name'
// $p::name;

// PHP Fatal error:  Uncaught Error: Undefined class constant 'name'
// Person::name;

assert(Person::$name === 'Mike');
// インスタンス変数が解決出来ない場合は、staticにアクセスを試みます。
assert($p::$name === 'Mike');

class Country
{
    public static $name = 'Japan';

    public function __construct()
    {
        // 最初はstaticプロパティしかないのでNoticeになります。
        // そのためエラーを抑制します。
        // Accessing static property Country::$name as non static
        if (@is_null($this->name)) {
            @$this->name = 'US';
        }
    }
}

$c = new Country;
// Accessing static property Country::$name as non static
assert(@$c->name === 'US');
assert($c::$name === 'Japan');
assert(Country::$name === 'Japan');

class Address
{
    // 大文字小文字は区別される。
    public static $NAME;
    public $name;
    public function __construct()
    {
        // staticプロパティはselfで参照。
        if (is_null(self::$NAME)) {
            @$this->name = 'Tokyo';
        }
    }
}

$a = new Address;
assert($a->name === 'Tokyo');
assert(is_null($a::$NAME));
