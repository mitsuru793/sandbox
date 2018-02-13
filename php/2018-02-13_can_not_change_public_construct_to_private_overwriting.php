<?php
/*
publicなコンストラクタをオーバーライドしてprivateにできない
*/
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

class P
{
    public function __construct() {}
}

class C extends P
{
    private function __construct() {}
}
