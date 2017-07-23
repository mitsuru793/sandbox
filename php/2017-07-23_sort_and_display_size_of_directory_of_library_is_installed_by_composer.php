<?php
/*
composerでインストールした各ライブラリのディレクトリサイズをソートして表示。

下記を使ってみる。
[symfony/finder: \[READ\-ONLY\] Subtree split of the Symfony Finder Component](https://github.com/symfony/finder)
*/
require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Finder\Finder;
use function Lib\puts;

// ライブラリのディレクトリを取得
$finder = new Finder();
$finder
->in(__DIR__ . '/vendor/')
->directories()
->depth('==1')
->exclude('bin');

// ディレクトリのサイズごとにソート
$i = 1;
$res = collect($finder)
->map(function ($file, $path) {
    return explode("\t", exec("du -s $path"));
})
->sort()
->each(function ($dir) use (&$i) {
    // 出力
    [$size, $path] = $dir;
    $libName = collect(explode('/', $path))->take(-2)->implode('/');
    $size = humanFileSize($size);
    puts("$i: $size\t$libName");
    $i++;
});

// thanks to https://stackoverflow.com/questions/15188033/human-readable-file-size
function humanFileSize(int $size, string $unit='') {
  if( (!$unit && $size >= 1<<30) || $unit == 'GB')
    return number_format($size/(1<<30),2).'GB';
  if( (!$unit && $size >= 1<<20) || $unit == 'MB')
    return number_format($size/(1<<20),2).'MB';
  if( (!$unit && $size >= 1<<10) || $unit == 'KB')
    return number_format($size/(1<<10),2).'KB';
  return number_format($size).' bytes';
}
