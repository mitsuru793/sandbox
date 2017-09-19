<?php
/*
VCRを使い、HTTPリクエストとレスポンスをファイルキャッシュして、外部APIをテストする。

[php\-vcr/php\-vcr: Record your test suite's HTTP interactions and replay them during future test runs for fast, deterministic, accurate tests\.](https://github.com/php-vcr/php-vcr)
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

const TEST = __DIR__ . '/tests/';
const FIXTURE = TEST . 'fixtures/';

function run()
{
    $fs = new Filesystem;
    if ($fs->exists(TEST)) {
        // /tests/を残して閲覧するならコメントアウトがオススメ
        throw new Exception("'" . TEST . "' will be remove at the end of this script.");
    }
    $fs->mkdir(FIXTURE);

    // このメソッド以降、VCRが全てのリクエストを補足します。
    \VCR\VCR::turnOn();


    // リクエストとレスポンスを引数で指定したファイルに保存します。
    // ルートパスは './tests/fixutres/'
    // このファイルをカセット(Cassette)と言う。パスを渡すことが可能。
    \VCR\VCR::insertCassette('hoge/example.yml');

    // 1回目のリクエストは実際に行われます。
    // 既に指定したカセットがある場合は、それを使いエミュレートします。
    $result = file_get_contents('http://example.com');
    assert('hello' !== $result);

    // カセットのresponse bodyの値を書き換えます。
    $contents = Yaml::parse(file_get_contents(FIXTURE . 'hoge/example.yml'));
    $contents[0]['response']['body'] = 'hello';
    file_put_contents(FIXTURE . 'hoge/example.yml', Yaml::dump($contents));

    // 再度HTTPリクエスト送るとカセットの内容が使われているため、bodyが変わります。
    $result = file_get_contents('http://example.com');
    assert('hello' === $result);


    // 1カセットに複数のリクエストがURLごとに保存されます。
    file_get_contents('http://google.com');
    $contents = Yaml::parse(file_get_contents(FIXTURE . 'hoge/example.yml'));
    assert(2 === count($contents));


    // リクエストを記録するのをやめ、カセットを取り出します。
    \VCR\VCR::eject();

    // カセットが未挿入の場合は、HTTPリクエストを送るとエラーになります。
    // file_get_contents('http://example.com');

    // リクエストの補足を停止します。
    \VCR\VCR::turnOff();

    // VCRを停止後なら、実際にHTTPリクエストを送れます。
    $result = file_get_contents('http://example.com');
    assert('hello' !== $result);

    // 生成したfixutreを確認するならコメントアウト
    $fs->remove(TEST);
}

run();
