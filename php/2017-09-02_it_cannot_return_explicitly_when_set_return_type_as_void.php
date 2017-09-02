<?php
/*
戻り値にvoidを渡すと、明示的にnullをreturnできなくなる。

空のreturnもnullが返るが、厳密には違うようだ。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

function hoge() : void
{
    return;
}
assert(is_null(hoge()));

// PHP Fatal error:  A void function must not return a value (did you mean "return;" instead of "return null;"?)
function bar() : void
{
    return null;
}
