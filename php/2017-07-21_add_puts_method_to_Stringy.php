<?php
/*
Stringyにputsメソッドを追加する。

[danielstjules/Stringy: A PHP string manipulation library with multibyte support](https://github.com/danielstjules/Stringy)
*/
require_once __DIR__ . '/vendor/autoload.php';

use Stringy\Stringy as Base;

class Stringy extends Base
{
    public function puts($level = 0, $indent = '    ') : void
    {
        $out = '';
        if ($level > 0) {
            while ($level--) {
                $out .= $indent;
            }
        }
        $out .= $this->str . PHP_EOL;
        echo $out;
    }
}

if (!function_exists('create')) {
    function create($str, $encoding = null)
    {
        return new Stringy($str, $encoding);
    }
}

create('hello')->puts();
create('hello')->puts(1);
create('hello')->puts(2, '@');
