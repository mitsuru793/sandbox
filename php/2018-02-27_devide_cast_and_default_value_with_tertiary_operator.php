<?php
/*
キャストとデフォルト値を分けるには三項演算子を使う
*/
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

$res = (int)null ?? true;
assert($res === 0);

$res = ((int)null) ?? true;
assert($res === 0);

$res = (int)(null ?? true);
assert($res === 1);

$res = null ? (int)$miss : true;
assert($res === true);
