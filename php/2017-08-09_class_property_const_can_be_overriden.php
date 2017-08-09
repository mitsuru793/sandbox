<?php
/*
クラスプロパティconstは、子クラスで上書きできる。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

class P
{
    const ID = 1;
}

class C extends P
{
    const ID = 2;
}

assert(P::ID === 1);
assert(C::ID === 2);
