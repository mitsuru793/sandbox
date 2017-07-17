<?php
/*
`get_object_vars($this)`で子クラスのprivateプロパティだけは取得できない。
*/

class P
{
    public function dump()
    {
        return get_object_vars($this);
    }
}

class C extends P
{
    public $pub = 1;
    protected $pro = 2;
    private $pri = 3;
}

$expected = [
    'pub' => 1,
    'pro' => 2,
];
$c = new C;
assert($expected === $c->dump());
