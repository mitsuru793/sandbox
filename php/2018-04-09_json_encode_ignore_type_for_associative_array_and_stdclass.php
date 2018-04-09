<?php
/*
json_encodeに連想配列、stdClassのどちらを渡しても結果は同じ

デコードする時は配列にするかstdClassにするか選べる。
*/
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

$o = new stdClass;
$o->name = 'mike';

assert('{"name":"mike"}' === json_encode($o));

$a = ['name' => 'mike'];
assert(json_encode($o) === json_encode($a));

$res = json_decode('{"name":"mike"}');
assert($res->name === 'mike');

$res = json_decode('{"name":"mike"}', true);
assert($res['name'] === 'mike');
