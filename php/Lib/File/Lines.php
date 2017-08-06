<?php
namespace Lib\File;

use Illuminate\Support\Collection;
use Lib\File\Line;

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
