<?php
/*
タイプヒントを子クラスで上書きすることはできない
*/

class P {}
class C extends P{}

class Text
{
    public function render(P $arg) {}

    public static function make() : self
    {
        return new Text;
    }
}
class Name extends Text
{
    // タイプヒントでは子クラスを許容できない。
    // インターフェースを使う必要がある。
    // public function render(C $arg) {}

    public function render(P $arg) {}

    // selfはNameを指すので駄目
    // public static function make() : self

    public static function make() : Text
    {
        return new Text;
    }
}
