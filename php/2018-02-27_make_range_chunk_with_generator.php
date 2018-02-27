<?php
/*
rangeのchunkをgeneratorで作る
*/
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

function rangeChunk(int $min, int $max, int $chunkSize): Generator
{
    for ($offset = $min; $offset <= $max; $offset += $chunkSize) {
        $limit = ($offset + $chunkSize - 1);
        $limit = min($max, $limit);
        yield range($offset, $limit);
    }
}

foreach (rangeChunk(0, 10, 2) as $range) {
    dump($range);
}
