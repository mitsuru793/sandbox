<?php
/*
委譲を使ったアダプタークラスを作る

[PHPによるデザインパターン入門 \- Adapter～APIを変更する \- Do You PHP はてな](http://d.hatena.ne.jp/shimooka/20141212/1418364494)

既に実用していてバグがないことをが保証されているクラスのソースコードに一切手を加えずに、APIを変更できる。
委譲ではなく継承だと、古いAPIを隠すことができない。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

function run()
{
    // メソッド名showNameをnameに変更
    $person = new Person('taro');
    assert('taro' === $person->showName());

    $user = new User('miki');
    assert('miki' === $user->name());
}

class Person
{
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function showName() : string
    {
        return $this->name;
    }
}

interface HasName
{
    public function name() : string;
}

class User implements HasName
{
    private $person;

    public function __construct(string $name)
    {
        $this->person = new Person($name);
    }
}
