<?php
/*
PhpRedisで値を更新する
*/
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

function sandbox($func) {
    $r = new Redis();
    if (@$r->connect('127.0.0.1')) {
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

// setで配列は保存できない
$sanboxes[] = function (Redis $r)
{
    $r->flushAll();
    assert($r->keys('*') === []);

    $r->set('name', 'mike');
    $r->set('names', ['mike', 'jane']);
    assert($r->get('name') === 'mike');
    assert($r->get('names') === 'Array');

    assertArrayOf($r->keys('*'), ['names', 'name']);
};

// msetに1次元配列を渡すとindexが数字になる。
// 厳密にはPHPは全て2次元配列で、数値のindexが文字列になった。
$sanboxes[] = function (Redis $r)
{
    $r->mset(['k1' => 'v1', 'k2' => 'v2']);
    assertArrayOf($r->keys('*'), ['k1', 'k2']);
    $r->flushAll();

    // msetに1次元配列
    $r->mset(['v1', 'v2']);
    assertArrayOf($r->keys('*'), ['1', '0']);
};

// incは数字のみ。文字は変化なし。
$sanboxes[] = function (Redis $r)
{
    $pairs = [
        [5, '6'],
        ['19', '20'],
        ['a', 'a'],
    ];
    foreach ($pairs as $pair) {
        [$val, $expected] = $pair;
        $r->set('k', $val);
        $r->incr('k');
        assert($r->get('k') === $expected);
    }
};

// delの戻り値は数値。
$sanboxes[] = function (Redis $r)
{
    $r->set('name', 'Michael');
    assert($r->del('name') === 1);
    assert($r->del('name') === 0);
    assert($r->get('name') === false);
};

foreach($sanboxes as $box) {
    sandbox($box);
}
