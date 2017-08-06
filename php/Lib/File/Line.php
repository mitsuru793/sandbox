<?php
namespace Lib\File;

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
        return preg_match('~(/\*|<!--)~', $this->value);
    }

    public function isCommentEnd() : bool
    {
        return preg_match('~(\*/|-->)~', $this->value);
    }
}

