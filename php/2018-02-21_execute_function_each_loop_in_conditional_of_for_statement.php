<?php
/*
for文の条件文に関数を使うと毎回実行される。
*/
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

function myCount(array $nums) {
    puts('@');
    return count($nums);
}

$nums = [1,2,3];
for ($i = 0; $i < myCount($nums); $i++) {
    puts((string)$i);
}
