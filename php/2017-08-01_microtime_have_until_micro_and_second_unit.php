<?php
/*
microtimeは秒単位で返す。小数はマイクロ秒単位まで持つという意味。
*/
require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

$start = microtime(true);
sleep(1);
puts(microtime(true) - $start);

$start = microtime(true);
sleep(2);
puts(microtime(true) - $start);
