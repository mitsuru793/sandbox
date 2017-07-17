<?php
/*
stdClassも自作クラスもis_objectの判定はtrueである。
*/

class Hoge {}

$o = new stdClass;
$hoge = new Hoge;

// どちらもオブジェクト
assert(is_object($o));
assert(is_object($hoge));

assert($o instanceof stdClass);
// $hogeはstdClassの子クラスではない
assert(! $hoge instanceof stdClass);
