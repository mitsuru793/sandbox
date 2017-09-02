<?php
/*
ErrorとExceptinのメソッドは同じ
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

$error = new Error('error msg');
$exception = new Exception('exception msg');

assert(get_class_methods($error) === get_class_methods($exception));
