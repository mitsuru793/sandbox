<?php
/*
連想配列に入れたクロージャを呼び出す
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

$options = [
    'func' => function() {
        return 'Hello';
    },
];

echo $options['func']();
