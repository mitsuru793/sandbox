<?php
/*
rewindはカーソルが0になるだけで、内容が残る。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;
use Zend\Diactoros\Response;

$response = new Response;
$body = $response->getBody();
$body->write('12345');
assert('12345' === (string)$body);

$body->rewind();
$body->write('6');
assert('62345' === (string)$body);

$body->write('7');
assert('623457' === (string)$body);
