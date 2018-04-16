<?php
/*
collectionのdiffはtargetにだけある値を検出するわけではない
*/
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

$user = collect([0, 1]);
assert($user->diff([1])->all() === [0]);
assert($user->diff([2])->all() === [0, 1]);
