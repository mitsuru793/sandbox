<?php
/*
VCRでtwitterクライアントで呼び出したAPIの通信内容をキャッシュする。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;
use Abraham\TwitterOAuth\TwitterOAuth;

const TEST = __DIR__ . '/tests/';
const FIXTURE = TEST . 'fixtures/';

function run()
{
    setup();
    $fs = new Filesystem;

    \VCR\VCR::turnOn();
    \VCR\VCR::insertCassette('example.yml');

    $twitter = createTwitterClient();
    $res = $twitter->get("statuses/user_timeline", [
        'screen_name' => 'twitter'
    ]);

    $contents = Yaml::parse(file_get_contents(FIXTURE . 'example.yml'));
    dump($contents);

    // パースに失敗したらfalseを返します。階層がオーバーした場合はnullです。
    $json = json_decode($contents[0]['response']['body']);
    assert(false !== $json);

    \VCR\VCR::eject();
    \VCR\VCR::turnOff();

    // 生成したfixutreを確認するならコメントアウト
    $fs->remove(TEST);
}

function setup()
{
    $dotenv = new Dotenv\Dotenv(__DIR__);
    $dotenv->load();

    $fs = new Filesystem;
    if ($fs->exists(TEST)) {
        // /tests/を残して閲覧するならコメントアウトがオススメ
        throw new Exception("'" . TEST . "' will be remove at the end of this script.");
    }
    $fs->mkdir(FIXTURE);
}

function createTwitterClient()
{
    return new TwitterOAuth(
        getenv('TWITTER_CONSUMER_KEY'),
        getenv('TWITTER_CONSUMER_SECRET'),
        getenv('TWITTER_ACCESS_TOKEN'),
        getenv('TWITTER_ACCESS_TOKEN_SECRET')
    );
}

run();
