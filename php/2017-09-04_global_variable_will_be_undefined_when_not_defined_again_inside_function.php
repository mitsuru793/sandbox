<?php
/*
関数内ではglobal変数は再定義しないとundefinedになる。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

function undefined()
{
    dump($argv);
}
// undefined();

function success()
{
    global $argv;
    dump($argv);
}
success();
