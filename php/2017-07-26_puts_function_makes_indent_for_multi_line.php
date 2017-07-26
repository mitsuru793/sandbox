<?php
/*
puts関数を複数行の場合のインデントに対応する。

1行目しかインデントに対応できていなかった。
*/
require_once __DIR__ . '/vendor/autoload.php';

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

puts('hello');
puts('hello', 1);
puts('hello', 2, '@');
$text = <<<'EOF'
0
    1
    1
        2
0
EOF;
puts($text, 2, '@');
