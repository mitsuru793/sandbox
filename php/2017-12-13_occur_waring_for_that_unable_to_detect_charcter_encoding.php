<?php
/*
Warning:  mb_convert_encoding(): Unable to detect character encodingを発生させる
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

$encodeList = ['ASCII', 'JIS', 'EUC-JP', 'SJIS'];

// UTF-8を抜いているので
// PHP Warning:  mb_convert_encoding(): Unable to detect character encoding
$str = mb_convert_encoding('你好', 'HTML-ENTITIES', $encodeList);
assert("你好" === $str);
assert('UTF-8' === mb_detect_encoding($str));
assert(false === mb_detect_encoding('你好', $encodeList));


$encodeList = array_merge($encodeList, ['UTF-8']);
$str = mb_convert_encoding('<p>你好</p>', 'HTML-ENTITIES', $encodeList);
assert('<p>&#20320;&#22909;</p>' === $str);
assert('ASCII' === mb_detect_encoding($str));
assert('UTF-8' === mb_detect_encoding('你好', $encodeList));
