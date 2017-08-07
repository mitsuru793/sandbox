<?php
/*
__setは内部メソッドの中でも適用される。
*/

function main()
{
    $p = new P;
    $p->name = 'Yamada';
    $p->set('age', 19);

    assert($p->name === '@Yamada');
    assert($p->age === '@19@');
}

class P
{
    public function __set($prop, $val)
    {
        $this->$prop = "@$val";
    }

    public function set($prop, $val)
    {
        $this->$prop = "$val@";
    }
}

main();
