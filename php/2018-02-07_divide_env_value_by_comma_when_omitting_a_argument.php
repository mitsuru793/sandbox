<?php
/*
引数が省略されたら、環境変数の値をカンマで分割する。
*/
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

function split($str = null): array
{
    $str = $str ?? getenv('MISSING');
    if (empty($str)) {
        return [];
    }
    return explode(',', $str);
}

assert(split() === []);
assert(split('a,b') === ['a', 'b']);

putenv('MISSING=c,d');
assert(split('a,b') === ['a', 'b']);
assert(split() === ['c', 'd']);
