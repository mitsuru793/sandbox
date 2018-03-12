<?php
/*
in_arrayの引数3を指定しないと型変換がされる
*/
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

$trues = [true, 1, '1', 'true', 'yes', 'ok'];
assert(true === in_array('false', $trues));

assert(true === in_array('false', [true]));
assert(false === in_array('false', [1]));
assert(false === in_array('false', ['1']));
assert(false === in_array('false', ['true']));
assert(false === in_array('false', ['yes']));
assert(false === in_array('false', ['ok']));

assert(false === in_array('false', $trues, true));
