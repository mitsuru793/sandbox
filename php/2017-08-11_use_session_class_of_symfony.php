<?php
/*
SymfonyのSessionクラスを使ってみる。

実装を見たところ、`$_SESSION`のラッパークラスという感じ。
Flush(FlushBag)とそれ以外(AttributeBag)は別々のクラス管理している。
*/

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Session\Session;
use function Lib\puts;

ini_set('session.save_path', './');

$session = new Session();
// 内部でsession_start()を実行し、各bugオブジェクトのデータを$_SESSIONに代入する。
$session->start();

dump($_SESSION);

$session->set('name', 'Yamada');
dump($session->get('name'));
dump($session->get('name'));

$session->getFlashBag()->add('notice', 'Hello World');
// getするとなくなる。peekなら覗くという意味で、なくならない。
dump($session->getFlashBag()->peek('notice'));
dump($session->getFlashBag()->get('notice'));
