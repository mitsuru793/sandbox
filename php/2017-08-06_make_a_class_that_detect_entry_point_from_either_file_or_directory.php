<?php
/*
pathがファイル・ディレクトリによってエントリーポイントを判断するクラスを作る。
*/
require_once __DIR__ . '/vendor/autoload.php';

use Lib\Value;

function main(array $argv)
{
    $paths = array_slice($argv, 1);
    foreach ($paths as $path) {
        dump(EntryPointPath::of($path));
    }
}

/**
 * pathがファイルなら自身を、ディレクトリなら中身の対象ファイルをエントリーポイントとして扱う。
 */
class EntryPointPath extends Value
{
    // 先頭の要素を優先して採用。
    public $entryFiles = [
      'index.html',
      'index.php',
      'main.js',
    ];

    public function __toString()
    {
        return $this->value;
    }

    protected function __construct(string $path)
    {
        if (is_file($path)) {
            $this->value = $path;
        }

        if (!is_dir($path)) return;
        foreach ($this->entryFiles as $file) {
            $entry = "$path/$file";
            if (file_exists($entry)) {
                $this->value = $entry;
                break;
            }
        }
    }
}

main($argv);
