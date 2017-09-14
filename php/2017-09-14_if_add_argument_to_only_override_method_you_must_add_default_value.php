<?php
/*
オーバーライドしたメソッドだけに引数を追加する時は、デフォルト値を追加すれば問題ない。

引数を省略出来るということは、親メソッドのシグネチャで呼び出すことが可能ということ。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

interface Auth
{
    public static function login(int $id) : bool;
}

class User implements Auth
{
    // $forceにデフォルト値を定義しないいけない
    public static function login(int $id, bool $force = false) : bool
    {
        return true;
    }
}

assert(User::login() === true);
