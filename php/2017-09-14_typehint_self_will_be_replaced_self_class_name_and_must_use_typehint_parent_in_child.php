<?php
/*
selfは自分自身に置き換わるので、継承先ではタイプヒントにparentで同値になる。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

class P
{
    public function hoge() : self
    {
        puts('parent');
        return $this;
    }
}

class C extends P
{
    // selfとするとCを指定することになるため、compatibleにならない。
    public function hoge() : parent
    {
        puts('child');
        // Pの子クラスCを返しているので良い。
        // C自体を返すとタイプヒントでは指定できない
        return $this;
    }
}

(new C)->hoge();
