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
