<?php
/*
LSTVのアクセスログから、BOT以外のリクエストパスとユーザーエージェントのペアを取り出す。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Stringy\create as s;
use function Lib\puts;

$file = $argv[1];

$ltsv = new Clover\Text\LTSV();
$values = $ltsv->parseFile($file);

const BOTS = [
    'heritrix',
    'Googlebot',
    'bingbot',
    'Python-urllib',
    'python-requests'
];

// リクエストパスのリスト
$requests = collect($values)->unique('request')
->reject(function ($v) {
    return s($v['http_user_agent'])->containsAny(BOTS);
})
->sortBy('request')
->map(function ($v) {
    $request = preg_replace('/GET\s+/', '', $v['request']);
    return "{$request} @ {$v['http_user_agent']}";
})
->implode(PHP_EOL);

puts($requests);
