<?php
/*
debug_backtraceで呼び出し元の関数を特定する。
*/
require_once __DIR__ . '/vendor/autoload.php';

function f1()
{
    return f2();
}

function f2()
{
    return f3();
}

function f3()
{
    return debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3);
}

[$one, $two, $three] = collect(f1())->pluck('function');
assert($one == 'f3');
assert($two == 'f2');
assert($three == 'f1');
