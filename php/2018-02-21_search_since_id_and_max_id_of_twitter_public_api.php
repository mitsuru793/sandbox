<?php
/*
Twitter Public APIのsince_idとmax_idの挙動を調べる

since_idとmax_idのどちらを指定しても、最新からcount分を取得しようとする。
max_idは最新のラインを下げるのに使う。
since_idからcount分を取得するわけではない。

max_idは「以下」を表し、指定idのツイートも含む。
since_idは「より大きい」を表し、指定idのツイートを含まない。
*/
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

// OAuthライブラリの読み込み
use Abraham\TwitterOAuth\TwitterOAuth;

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

//接続
$connection = new TwitterOAuth(
    getenv('TWITTER_CONSUMER_KEY'),
    getenv('TWITTER_CONSUMER_SECRET'),
    getenv('TWITTER_ACCESS_TOKEN'),
    getenv('TWITTER_ACCESS_TOKEN_SECRET')
);

$res = $connection->get("statuses/user_timeline", [
    'screen_name' => 'dummy_samples',
    'count' => 3,
    // 'max_id' => 953890556454711297,
    // 'since_id' => 917689381913116672,
]);

/*
953890556454711297
引用RT
https://t.co/T3rWWKfKwf

917689381913116672
link: togetter まとめページ
https://t.co/ZgskRNtQK5
*/

collect($res)->each(function ($item, $key) {
    puts($item->id_str);
    puts($item->text);
    puts('');
});
