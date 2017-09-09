<?php
/*
mixedな値をラップして、1つの型に変換すると使いやすくなる。

StringyやCollectionを参考
mixedの値をコンストラクタで1つの型に変換すると使いやすくなる。
例外も自分で用意すれば、動的言語の良さを活かすことができる。
戻り値は固定した方がよいと思う。タイプヒントをつけよう。
*/

require_once __DIR__ . '/vendor/autoload.php';

use Stringy\Stringy as S;
use function Stringy\create as s;
use function Lib\puts;

function run()
{
    // 3つの書き方がある。一番書きやすく、楽しいのがヘルパー関数。
    // namespaceをつければグローバル関数にならずに済む。
    $s = new S('hello');
    assert('hello' === (string)$s);

    $s = S::create('hello');
    assert('hello' === (string)$s);

    $s = s('hello');
    assert('hello' === (string)$s);

    // Stringyだけでなく他のtoStringを実装したオブジェクトも渡せる。
    // 自分自身を渡せるとスカラ値なのか気にする必要がなくなる。
    $hoge = new Hoge;
    $s = s('hello');
    $s = s($s);
    assert('hello' === (string)$s);

    $s = s($hoge);
    assert('hoge str' === (string)$s);
}

class Hoge
{
    public function __toString()
    {
        return 'Hoge str';
    }
}
