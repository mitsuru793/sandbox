<?php
/*
Closure::callで非publicメンバにアクセスする

Closure::callでboolを返す判定メソッドを作った。
使う時にcallというタイプヒントも増えるので今回の使い方だと、関数定義の方がメリットが有る。
Closureだと`$this`にタイプヒントが使えない。

メリットは`$this`に束縛するので、非publicメンバにアクセス出来ること。
テスト時に役に立ちそう。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

class Age
{
    private $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }

    private function double(): int
    {
        return $this->value * 2;
    }
}

// 成人年齢かを判定する。何歳を成人とするかを変更可能。
function run()
{
    // Closure
    $isAdult = function (int $adultLine = 20) { return $this->value() >= $adultLine; };
    assert(false === $isAdult->call(new Age(18)));
    assert(true === $isAdult->call(new Age(18), 18));
    assert(true === $isAdult->call(new Age(21)));

    // Function
    function isAdult(Age $age, $adultLine = 20): bool
    {
        return $age->value() >= $adultLine;
    }
    assert(false === isAdult(new Age(18)));
    assert(true === isAdult(new Age(18), 18));
    assert(true === isAdult(new Age(21)));

    // call private
    $doubleAge = function () { return $this->double(); };
    assert(22 === $doubleAge->call(new Age(11)));
}

run();
