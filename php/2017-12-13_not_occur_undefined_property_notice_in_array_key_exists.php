<?php
/*
オブジェクトのUndefinedプロパティへアクセスした時は、Noticeになるがarray_key_existsでは発生しない。

strict_typesを有効にしてもNoticeがエラーになることはない。
*/
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

$o = new stdClass;

// No Error
array_key_exists('name', $o);

// PHP Notice:  Undefined property: stdClass::$name
$o->name;

echo 'finish';
