<?php
/*
undefinedプロパティのアクセスに否定のビックリマークを使ってもNoticeは発生する
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

$o = new stdClass;
assert(true === !$o->name);
