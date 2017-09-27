<?php
/*
タイプヒントにstdClassが使える
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

class Hoge
{
    public function hello(stdClass $o, bool $returnNull): ?stdClass
    {
        return $returnNull ? null : $o;
    }
}

$h = new Hoge;
$o = new stdClass;
$h->hello($o, true);
$h->hello($o, false);
