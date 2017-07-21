<?php
/*
gitで管理しているファイルを拡張子ごとに、ファイル数と行数を表示する。

ステージングにあるファイルもカウントされる。
小さなスクリプトを書くには、下記を拡張すると良い。
[sebastianbergmann/git: Simple PHP wrapper for Git](https://github.com/sebastianbergmann/git)
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\create as s;
use SebastianBergmann\Git\Git as Base;

class Git extends Base
{
    public function getFilePaths() : array
    {
        $output = $this->execute('ls-files');
        return $output;
    }

}

$git = new Git(__DIR__);
$fileInfo = collect($git->getFilePaths())
    ->reduce(function ($info, $path) {
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if (empty($info[$ext])) {
            $info[$ext] = [
                'fileNum' => 0,
                'lineNum' => 0,
            ];
        }

        $info[$ext]['fileNum']++;
        $info[$ext]['lineNum'] += count(file($path));
        return $info;
    });

collect($fileInfo)->each(function ($info, $ext) {
        s($ext ?: 'no extension')->puts();
        s("total file: {$info['fileNum']}, line: {$info['lineNum']}")->puts();
        echo PHP_EOL;
    });
