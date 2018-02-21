<?php
/*
キャプチャしたものもpreg_splitの結果に含める
*/
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

$str = 'apple @banana@ grape';

$result = preg_split('/@\w+@/', $str, -1, PREG_SPLIT_DELIM_CAPTURE);
assert($result === ['apple ', ' grape']);

$result = preg_split('/(@\w+@)/', $str, -1, PREG_SPLIT_DELIM_CAPTURE);
assert($result === ['apple ', '@banana@', ' grape']);
