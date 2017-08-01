<?php
/*
popenを使い、外部スクリプトの出力を終わるまで待たずに出力する。

仕組みは分かっていない。
*/
error_reporting(E_ALL);

// bashスクリプトの作成
$file = tmpfile();
fwrite($file, <<<'EOF'
echo -n '入力してください> '
read tmp
echo repeat $tmp
EOF
);
$path = stream_get_meta_data($file)['uri'];

$handle = popen("bash $path", 'r');

$read = fread($handle, 2024);
echo $read; // '入力してください> '

// freadを使わないと、入力後にパイプでエラーになる。
// /private/var/folders/p6/zm1pft7j33jbbtg64ytbxk7r0000gn/T/phpht8E4I: line 3: echo: write error: Broken pipe
$read = fread($handle, 2024);
echo $read; // repeat $tmp <-展開される
pclose($handle);

fclose($file);
