<?php
/*
LaravelのCarbonを使ってみる

毎回インスタンス生成時にtimezoneを設定しないといけないのか？
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

use Carbon\Carbon;

const TIMEZONE = 'Asia/Tokyo';
$now = Carbon::now(TIMEZONE);
puts($now);

$day30 = Carbon::create(2017, 12, 30, 12, 0, 0);
dump($now->gte($day30));
dump($now->gte(Carbon::create(2017, 12, 29, 0, 0, 0, TIMEZONE)));
