<?php
/*
underscore.phpのクラスメソッドを呼び出している部分を正規表現で抽出する

`__::pluck($people, 'name');`
*/

require_once __DIR__ . '/vendor/autoload.php';

function main()
{
    $regexp = '__::';
    // gitで管理しているphpファイルを対象にgrep
    $out = shell_exec("ag --php --nofilename '$regexp'");

    // '__::...'の部分だけを抽出
    $lines = collect(explode(PHP_EOL, $out))
    ->map(function ($line) use ($regexp) {
        // 先頭の空白と空行を削除
        $noIndentLine = preg_replace('/^\s+/', '', $line);
        // 先頭の空白と空行を削除
        return preg_replace("/^.*(?=$regexp)/", '', $noIndentLine);
        //
    })->filter(function ($line) {
        return !preg_match('/^$/', $line);
    })
    ->sort()
    ->values() // sortではindexの振り直しはないのでvaluesで振り直す。
    ->all();

    echo implode(PHP_EOL, $lines);
}
main();
