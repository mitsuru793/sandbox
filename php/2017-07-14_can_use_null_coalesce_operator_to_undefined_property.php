<?php
/*
null合体演算子は未定義なプロパティに使える。
*/
$o = new stdClass;
assert($o->no ?? 'default' === 'default');
