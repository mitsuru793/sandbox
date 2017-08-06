<?php
namespace Lib;

/**
 * バリューオブジェクトを表す。
 * スカラ型のラッパークラスに近い。
 *
 * 外側からはOfメソッドでしか生成できないので、
 * ValueObjectとそれ以外の見分けがつく。
 *
 * ※ constructは子クラスでprotectedにする必要がある。強制はできない。
 *   (constructでタイプヒントを扱えるようにするため。)
 */
abstract class Value implements \JsonSerializable
{
    protected $value;

    public static function of($value)
    {
        return new static($value);
    }

    public function isEmpty() : bool
    {
        return empty($this->value);
    }

    public function isNotEmpty() : bool
    {
        return !empty($this->value);
    }

    public function jsonSerialize()
    {
        return $this->value;
    }
}
