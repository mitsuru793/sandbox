<?php
/*
twitter apiを"abraham/twitteroauth"で叩く
*/
require __DIR__ . '/vendor/autoload.php';

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

// dumpを確認したい$resの下に移動すればいい

$res = $connection->get("statuses/user_timeline", [
    'screen_name' => 'dummy_samples'
]);

$res = $connection->get("account/settings", [
    'screen_name' => 'dummy_samples'
]);

$res = $connection->get("users/lookup", [
    'screen_name' => 'dummy_samples'
]);

$res = $connection->get("friendships/show", [
    'source_screen_name' => 'dummy_samples',
    'target_screen_name' => 'Twitter'
]);

$res = $connection->get("statuses/lookup", [
    // 引用RT
    'id' => '880865408365903872',
]);

dump($res);
