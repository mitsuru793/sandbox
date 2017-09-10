<?php
/*
interfaceにマジックメソッドも定義できるため、Commandパターンでexecuteの代わりにinvokeが使える。

分かりづらい気もするので、メソッド名はexecuteの方がいいかも。
インターフェースで統一は出来ているので。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

function run()
{
    $hi = new HiCommand('Mike');
    ob_start();
    $hi();
    assert('Hi, Mike' === ob_get_clean());
}

interface Command
{
    public function __invoke();
}

class HiCommand implements Command
{
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function __invoke()
    {
        echo "Hi, {$this->name}";
    }
}

run();
