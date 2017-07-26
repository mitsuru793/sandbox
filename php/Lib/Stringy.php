<?php
namespace Lib;

use Stringy\Stringy as Base;
use function Lib\puts;

class Stringy extends Base
{
    public function puts($level = 0, $indent = '    ') : void
    {
        puts($this->str, $level, $indent);
    }
}
