<?php
/*
PHPファイルの先頭のコメントブロックを解析して、タイトルと詳細の目次をMarkdownで出力する。

コメントは複数行のスターで書く。
１行目にタイトル、以降に詳細分を記述する。

```
script a.php b.php
=>
### a.php
[souce](./a.php)

### b.php
source(./b.php)
説明です。
```
*/

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Collection;

function main(array $argv)
{
    if (count($argv) < 2) {
        throw new ArgumentCountError('Arguments must be more than 1');
    }

    $filePaths = array_slice($argv, 1);
    $posts = Posts::fromFiles($filePaths);

    $content = $posts->reduce(function ($content, $post) {
        $content = implode(PHP_EOL, [
            $content,
            "### {$post->title}",
            '[source](./' . basename($post->path) . ')',
        ]);
        if (!empty($post->body)) {
            $content .= PHP_EOL . trim($post->body);
        }
        return $content . PHP_EOL;
    });
    echo $content;
}

class Posts extends Collection
{
    public function __construct($posts)
    {
        parent::__construct($posts);
    }

    public static function fromFiles(array $paths) : self
    {
        $posts = array_map(function($path) { return new Post($path); }, $paths);
        return new static($posts);
    }
}

class Post
{
    public $path;
    public $title;
    public $lines;
    public $body;

    public function __construct(string $path)
    {
        $this->path = $path;
        $post = $this->parseFile($this->path);
        $this->title = $post['title'];
        $this->lines = $post['lines'];
        $this->body = $this->lines->implode('value', PHP_EOL);
    }

    private function parseFile($filePath) : array
    {
        $lines = Lines::fromFile($filePath)->frontMatter();
        return [
            'title' => $lines->get(0)->value,
            'lines' => $lines->slice(1)->values(),
        ];
    }
}

class Lines extends Collection
{
    public function __construct(array $lines)
    {
        parent::__construct($lines);
    }

    public static function fromFile(string $filePath) : self
    {
        $lines = explode(PHP_EOL, file_get_contents($filePath));
        $lines = array_map(function ($line) { return new Line($line); }, $lines);
        return new static($lines);
    }

    /**
     * 先頭のコメントブロックの中身を抽出
     */
    public function frontMatter() : self
    {
        $lines = [];
        $inComment = false;
        $this->each(function ($line) use (&$lines, &$inComment) {
            if ($line->isCommentStart()) {
                $inComment = true;
                return;
            }
            if ($line->isCommentEnd()) {
                return false;
            }
            if ($inComment) {
                $lines[] = $line;
            }
        });
        return new static($lines);
    }
}

/**
 * PHPの複数行の開始と終わりを判断できる。
 */
class Line
{
    public $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function isCommentStart() : bool
    {
        return preg_match('~/\*~', $this->value);
    }

    public function isCommentEnd() : bool
    {
        return preg_match('~\*/~', $this->value);
    }
}

main($argv);
