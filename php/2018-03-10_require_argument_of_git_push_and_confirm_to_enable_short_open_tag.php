<?php
/*
phpでgit pushの引数を必須にして、short_open_tagが有効かをチェックする。
*/
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

puts('init start');
puts('');

command('git config push.default nothing');

if (!(bool)ini_get('short_open_tag')) {
    throw new Exception('ローカルのphp.iniのshort_open_tagを有効にして下さい。');
}

puts('');
puts('init done');

function command($command): void
{
    puts($command);
    exec($command);
}
