<?php
namespace Lib;

use Lib\Stringy;

function create($str, $encoding = null)
{
    return new Stringy($str, $encoding);
}

function puts(string $str, $level = 0, $indent = '    ')
{
    $out = '';
    $lines = explode(PHP_EOL, $str);
    foreach ($lines as $line) {
        if ($level > 0) {
            for ($i = 0; $i < $level; $i++) {
                $out .= $indent;
            }
        }
        $out .= $line . PHP_EOL;
    }
    echo $out;
}

function execTime(callable $fn, int $num = 1) : float
{
    $start = microtime(true);
    for ($i = 0; $i < $num; $i++) {
        $fn();
    }
    return microtime(true) - $start;
}

function putsExecTime(callable $fn, int $num = 1, $level = 0, $indent = '    ') : void
{
    puts(execTime($fn, $num), $level, $indent);
}
