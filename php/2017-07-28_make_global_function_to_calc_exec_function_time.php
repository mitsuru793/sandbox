<?php
/*
関数の実行時間を測るグローバル関数を作る
*/
require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

function execTime(callable $fn) : float
{
    $start = microtime(true);
    $fn();
    return microtime(true) - $start;
}

function putsExecTime(callable $fn, $level = 0, $indent = '    ') : void
{
    puts(execTime($fn), $level, $indent);
}

putsExecTime(function () {
    sleep(1);
}, 2, '@');
