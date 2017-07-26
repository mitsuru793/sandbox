<?php
namespace Lib;

use Lib\Stringy;

if (!function_exists('Lib\create')) {
    function create($str, $encoding = null)
    {
        return new Stringy($str, $encoding);
    }
}

if (!function_exists('Lib\puts')) {
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
}

