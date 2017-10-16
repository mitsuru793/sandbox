<?php
/*
traitにinterfaceが使えないので他のtraitで代用する

抽象メソッド集のtraitを、traitでuseすれば良い。
PrifixはHasかDeclares。後者が良い気がする。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

trait DeclaresSays
{
    abstract function say(): string;
}

trait MainTrait
{
    use DeclaresSays;

    /**
     * {@phpdoc}
     */
    public function say(): string
    {
        return 'hello';
    }
}

class User
{
    use MainTrait;
}

$user = new User;
assert('hello' === $user->say());
