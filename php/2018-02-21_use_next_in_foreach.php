<?php
/*
foreachで次の要素を取得するのにnextを使う

nextがない場合はfalseを返す。
nextを1ループで複数回使うと困る。
*/
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

$nums = [1,2,3,4,5];

foreach ($nums as $n) {
    echo $n . next($nums) . PHP_EOL;
}

// 再度foreachしても影響はない
foreach ($nums as $n) {
    echo $n . next($nums) . PHP_EOL;
}

foreach ($nums as $n) {
    echo $n . next($nums) . next($nums). PHP_EOL;
}
