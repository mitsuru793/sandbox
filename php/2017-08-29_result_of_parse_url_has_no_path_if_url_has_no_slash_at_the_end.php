<?php
/*
末尾に/が無いと、parse_urlの結果にpathも無くなる。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

$parts = parse_url('https://google.com');
assert(!isset($parts['path']));

$parts = parse_url('https://google.com/');
assert($parts['path'] === '/');
