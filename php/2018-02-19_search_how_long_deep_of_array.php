<?php
/*
配列の一番深い階層を調べる

thanks: https://stackoverflow.com/questions/262891/is-there-a-way-to-find-out-how-deep-a-php-array-is
*/
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

$user = [
    'id',
    'user' => [
        'name',
        'age',
        'family' => ['man', 'woman']
    ]
];

function array_depth(array $array): int
{
    $maxDepth = 1;

    foreach ($array as $value) {
        if (!is_array($value)) continue;
        $depth = array_depth($value) + 1;
        if ($depth > $maxDepth) $maxDepth = $depth;
    }

    return $maxDepth;
}
echo array_depth($user) . PHP_EOL;

function array_depth2(array $array): int
{
    $maxIndent = 1;

    $arrayStr = print_r($array, true);
    $lines = explode(PHP_EOL, $arrayStr);

    foreach ($lines as $line) {
        $indent = (strlen($line) - strlen(ltrim($line))) / 4;

        if ($indent > $maxIndent) {
            $maxIndent = $indent;
        }
    }

    return (int)ceil(($maxIndent - 1) / 2) + 1;
}
echo array_depth2($user) . PHP_EOL;
