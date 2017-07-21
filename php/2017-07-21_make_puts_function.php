<?php
/*
改行をつけるecho、puts関数を作る。

ライブラリとしてローカルに置いておくと便利です。インデントもつけれます。
*/

function puts(string $str, $level = 0, $indent = '    ')
{
    $out = '';
    if ($level > 0) {
        while ($level--) {
            $out .= $indent;
        }
    }
    $out .= $str . PHP_EOL;
    echo $out;
}

puts('hello');
puts('hello', 1);
puts('hello', 2, '@');
