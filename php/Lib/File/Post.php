<?php
namespace Lib\File;

use Lib\File\Lines;

/**
 * 記事ファイルをパースする。
 */
class Post
{
    public $path;
    public $title;
    public $date;
    public $lines;
    public $body;

    public function __construct(string $path)
    {
        $this->path = $path;
        $post = $this->parseFile($this->path);
        $this->title = $post['title'];
        $this->date = $post['date'];
        $this->lines = $post['lines'];
        $this->body = $this->lines->implode('value', PHP_EOL);
    }

    private function parseFile($filePath) : array
    {
        $lines = Lines::fromFile($filePath)->frontMatter();
        preg_match('/^\d{4}-\d{2}-\d{2}/', $filePath, $matches);
        return [
            'title' => $lines->get(0)->value,
            'date' =>$matches[0],
            'lines' => $lines->slice(1)->values(),
        ];
    }
}
