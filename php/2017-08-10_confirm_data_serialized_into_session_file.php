<?php
/*
セッションファイルにシリアライズされたデータを確認する
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

// session_start()を実行しないと変数自体が定義されない
// Notice: Undefined variable: _SESSION
// $_SESSION;

// iniでセットしない場合は毎回変更する必要がある
assert(session_save_path() === '');
session_save_path('./');

// セッションファイルへのシリアル化
// シリアル化データを復元するために使用されるハンドラの名前を定義
if (ini_get('session.serialize_handler') !== 'php') {
    ini_set('session.serialize_handler', 'php');
}

assert(session_name() === 'PHPSESSID');

session_start();

dump($_SESSION);

$_SESSION['string'] = 'hello';
$_SESSION['num array'] = [1,2,3];

$o = new stdClass;
$o->name = 'yamada';
$_SESSION['object'] = $o;

// セッションファイルに書き込む内容
dump(session_encode());
dump(session_id());

$sessionContent = file_get_contents('./sess_'.session_id());
dump($sessionContent === session_encode());
