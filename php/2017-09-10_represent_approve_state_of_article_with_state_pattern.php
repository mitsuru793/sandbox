<?php
/*
記事の承認ステータスをStateパターンで表現する。

[PHPによるデザインパターン入門 \- State～状態を表す \- Do You PHP はてな](http://d.hatena.ne.jp/shimooka/20141219/1418965549)

nextStateは一方向でしか使えない。状態が分岐する場合には使えない。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

function run()
{
    $state = DraftState::getInstance();
    assertState($state, [
        'Draft' => true,
        'ApprovedRequest' => false,
        'Approved' => false,
    ]);

    $state = $state->nextState();
    assertState($state, [
        'Draft' => false,
        'ApprovedRequest' => true,
        'Approved' => false,
    ]);

    $state = $state->nextState();
    assertState($state, [
        'Draft' => false,
        'ApprovedRequest' => false,
        'Approved' => true,
    ]);

    assert($state->nextState() === null);
}

function assertState(ArticleState $articleState, array $pattern)
{
    foreach ($pattern as $state => $returned) {
        $method = "is{$state}";
        assert($articleState->$method() === $returned);
    }
}

interface Singleton
{
    public static function getInstance();
}

trait HasSingleton
{
    private static $instance = null;

    private function __construct()
    {
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new self;
        }
        return self::$instance;
    }
}

interface ArticleState
{
    public function isDraft() : bool;
    public function isApproved() : bool;
    public function isApprovedRequest() : bool;
    public function nextState() : ?ArticleState;
}

trait ArticleDefaultState
{
    public function isDraft() : bool
    {
        return false;
    }

    public function isApproved() : bool
    {
        return false;
    }

    public function isApprovedRequest() : bool
    {
        return false;
    }
}

class DraftState implements ArticleState, Singleton
{
    use HasSingleton;
    use ArticleDefaultState;

    public function isDraft() : bool
    {
        return true;
    }

    public function nextState() : ?ArticleState
    {
        return ApprovedRequestState::getInstance();
    }
}

class ApprovedRequestState implements ArticleState, Singleton
{
    use HasSingleton;
    use ArticleDefaultState;

    public function isApprovedRequest() : bool
    {
        return true;
    }

    public function nextState() : ?ArticleState
    {
        return ApprovedState::getInstance();
    }
}

class ApprovedState implements ArticleState, Singleton
{
    use HasSingleton;
    use ArticleDefaultState;

    public function isApproved() : bool
    {
        return true;
    }

    public function nextState() : ?ArticleState
    {
        return null;
    }
}

run();
