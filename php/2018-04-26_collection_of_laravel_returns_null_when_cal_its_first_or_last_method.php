<?php
/*
laravelのCollectionのfirstとlastは空配列に使うとnullが返る。
*/
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;
use Illuminate\Support\Collection;

$c = new Collection([]);
assert(is_null($c->first()));
assert(is_null($c->last()));
