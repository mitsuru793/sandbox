<?php
/*
クラス定数でプロパティを初期化する
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;


class User
{
    const DEFAULT_NAME = 'nanashi';

    public $name = self::DEFAULT_NAME;

    public function __construct($name = null)
    {
        if (!is_null($name)) {
            $this->name = $name;
        }
    }
}

$u1 = new User;
assert($u1->name === 'nanashi');

$u2 = new User('yamada');
assert($u2->name === 'yamada');
