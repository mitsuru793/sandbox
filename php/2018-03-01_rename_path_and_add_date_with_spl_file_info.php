<?php
/*
パスをリネームして日付を付けるのをSplFileInfoでやってみる
*/
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

function addDateAndTitle(string $filePath, array $titleWords): string
{
    $f = new SplFileInfo($filePath);
    $ext = $f->isDir() ? '' : '.' . $f->getExtension();

    return sprintf('%s/%s_%s%s',
        $f->getPath(),
        date('Y-m-d'),
        implode('_', $titleWords),
        $ext
    );
}

$filePath = $argv[1];
$titleWords = array_slice($argv, 2);
$renamed = addDateAndTitle($filePath, $titleWords);
dump($renamed);
