<?php
/*
組み込み関数strip_tagsの挙動を確認する

許可したHTMLタグだけ削除しないホワイトリスト方式
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

puts(strip_tags('<p>hello</p><img>', '<p><img>'));
// <p>hello</p><img>

puts(strip_tags('start<?php echo "hello" ?>', ''));
// start

$text = '<a onmouseover="alert(document.cookie)">XSS</a>';
puts(strip_tags($text, '<a>'));
// <a onmouseover="alert(document.cookie)">XSS</a>

$text = '<ScrIpt>alert(1);</SCript>';
puts(strip_tags($text, '<script>'));
// <ScrIpt>alert(1);</SCript>
