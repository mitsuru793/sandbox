<?php
/*
PhpRedisにprefixを有効にすると、keyに自動で付与される。
*/
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

function sandbox($func) {
    $r = new Redis();

    if (@$r->connect('127.0.0.1')) {
        // prefixを設定できる。設定するとデータは消える
        $r->setOption(Redis::OPT_PREFIX, 'sandbox:');
        $func($r);
    }
    $r->flushAll();
}

/**
 * 順不同で$targetの要素は$expectedのみか?
 */
function assertArrayOf(array $target, array $expected)
{
    foreach ($target as $v) {
        if (!in_array($v, $expected)) {
            assert(false);
            return;
        }
    }
}

$sanboxes = [];

$sanboxes[] = function (Redis $r)
{
    // prefixのゲッターに値を渡すと、文字列をjoinできる。
    assert($r->_prefix('value') === 'sandbox:value');

    $r->set('age', 5);
    assert($r->get('age') === '5'); // 自動でprefixが付く
    assertArrayOf($r->keys('*'), ['sandbox:age']);
};

// msetでも全てにprefixが付く
$sanboxes[] = function (Redis $r)
{
    $r->mset(['k1' => 'v1', 'k2' => 'v2']);
    assert($r->keys('*') === ['sandbox:k1', 'sandbox:k2']);
};

// msetでも全てにprefixが付く
$sanboxes[] = function (Redis $r)
{
    $r->hSet('h', 'k1', 'v1');
    $r->hMSet('h', ['k2' => 'v2', 'k3' => 'v3']);
    assert($r->keys('*') === ['sandbox:h']);
    assert($r->hGetAll('h') === [
        'k1' => 'v1',
        'k2' => 'v2',
        'k3' => 'v3',
    ]);
};

foreach($sanboxes as $box) {
    sandbox($box);
}
