<?php
/*
複数トレイトをuseして衝突するとfatalエラーだが、トレイトでトレイトを使った場合はオーバーライドされる。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

trait A
{
    public function say()
    {
        return 'from A';
    }
}

trait B
{
    use A;
    public function say()
    {
        return 'from B';
    }
}

class Hoge
{
    use B;
}

$h = new Hoge;
assert('from B' === $h->say());
