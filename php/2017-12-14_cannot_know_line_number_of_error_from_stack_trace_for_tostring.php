<?php
/*
__toStingの中でエラーが発生してもスタックトレースで発生箇所の行数が分からない。

> __toString() メソッド内から例外を投げることはできません。そうした場合、致命的なエラーが発生します。
http://php.net/manual/ja/language.oop5.magic.php

> Fatal error: Method class@anonymous::__toString() must not throw an exception, caught Error:
が発生するから追えない?
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

$view = new class {
    public function __toString()
    {
        return invalid();
    }

    public function render()
    {
        return invalid();
    }
};

// スタックトレースだと0行目が例外の発生箇所になる
// (string)$view;

// スタックトレースが詳細に表示される
// $view->render();

// __toStringだとスタックトレースが表示出来ないがechoで出力できる。
/* <?= $user ?> という使い方もできるようになる。*/
$user = new class {
    public function __toString()
    {
        return 'Mike';
    }
};
echo $user . PHP_EOL;

// > __toString() メソッド内から例外を投げることはできません。そうした場合、致命的なエラーが発生します。
// http://php.net/manual/ja/language.oop5.magic.php

$view = new class {
    public function __toString(): string
    {
        throw new Exception('my error');
    }
};
// (string)$view;

// __toStringの外で発生したFatal Errorだとスタックトレースで行数が分かる。
// invalid();

// マジックメソッドではないtoStringを実装する必要がある。
$view = new class {
    public function toS(): string
    {
        return invalid();
    }
};
// echo $view->toS();
