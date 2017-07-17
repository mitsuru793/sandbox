<?php
/*
コンストラクタはオーバーライドする時にシグネチャを変更できる。
*/

class P
{
    public function __construct() {}

    public function say($word) {}

    public function tell($to) : bool
    {
        return true;
    }
}

class C extends P
{
    // タイプヒントの変更だけでなく、引数を追加できる。
    public function __construct(string $arg) {}

    // メソッドだとタイプヒントを追加することもできない。
    // public function say(string $word) {}

    // 戻り値は追加することできる。
    public function say($word) : string
    {
        return '';
    }

    // 戻り値の型を変更することは出来ない。
    // public function tell($to) : string
    // {
    //     return '';
    // }
}

new P;
new C('str');
