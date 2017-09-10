<?php
/*
Bridgeパターンで機能と実装を分けてクラスを実装する

[PHPによるデザインパターン入門 \- Bridge～実装と機能の架け橋 \- Do You PHP はてな](http://d.hatena.ne.jp/shimooka/20141216/1418705115)

機能クラスはファサードに近い感じがする。実装は別クラスに委譲しており、実装の最上位はインターフェースを使うとテンプレートメソッドになる。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

function run()
{

    $auth = new Auth('123');
    $auth->login();
    $auth->logout();
}

// 機能のAPIを決めている。クライアント側がこのクラスを使用。
// 役割ごとに認証処理を変更する場合は、実装クラスを変えるだけで良い。
class Auth
{
    private $id;

    public function __construct(int $userId)
    {
        $this->id = $userId;
    }

    public function login()
    {
        (new UserAuth($this->id))->login();
    }

    public function logout()
    {
        (new UserAuth($this->id))->logout();
    }
}

// 実装のAPIを決めている。
class UserAuth implements Loginable
{
    use HasLogin;

    private $id;

    public function __construct(int $userId)
    {
        $this->id = $userId;
    }
}

class AdminAuth implements Loginable
{
    use HasLogin;

    private $id;

    public function __construct(int $userId)
    {
        $this->id = $userId;
    }
}

interface Loginable
{
    public function login();
    public function logout();
}

trait HasLogin
{
    public function login()
    {
        puts("id: {$this->id} is logged in.");
    }

    public function logout() {
        puts("id: {$this->id} is logged out.");
    }
}

run();
