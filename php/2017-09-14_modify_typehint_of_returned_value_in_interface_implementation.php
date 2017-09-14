<?php
/*
interfaceの実装先で、戻り値のタイプヒントを変更したい。

同じシグネチャのloginメソッドでUserとAdminのどちらかを返す。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

/**************************************************************/
/* intefaceで戻り値のtypehintをつけずに、実装クラスで定義する */
/**************************************************************/

interface AuthInterface1
{
    // 継承先で戻り値のtypehintが違うため、interfaceで定義できない
    // PHPDocで戻り値をobjectかModelと書く。
    /**
     * object
     */
    public static function login();
}

// selfは自分自身のクラス名を表すので、定義クラスによってselfの値は変わる。
class User1 implements AuthInterface1
{
    public static function login() : self
    {
        return new self;
    }
}

class Admin1 implements AuthInterface1
{
    public static function login() : self
    {
        return new self;
    }
}

assert(User1::login() instanceof User1);
assert(Admin1::login() instanceof Admin1);

/******************************************/
/* 空のintefaceでUser系にマーカーをつける */
/* 親クラスを後から定義出来ない時に使える */
/******************************************/


interface AuthInterface2
{
    public static function login() : UserInterface;
}

interface UserInterface {}

class User2 implements AuthInterface2, UserInterface
{
    public static function login() : UserInterface
    {
        return new self;
    }
}

class Admin2 implements AuthInterface2, UserInterface
{
    public static function login() : UserInterface
    {
        return new self;
    }
}

assert(User2::login() instanceof UserInterface);
assert(User2::login() instanceof User2);
assert(Admin2::login() instanceof UserInterface);
assert(Admin2::login() instanceof Admin2);

/*************************************************/
/* interfaceを継承して戻り値だけを追加で定義する */
/*   戻り値の種類ごとにインターフェースが増える  */
/*************************************************/

interface AuthInterface3
{
    public static function login();
}

interface UserAuthInterface extends AuthInterface3
{
    public static function login() : User3;
}

interface AdminAuthInterface extends AuthInterface3
{
    public static function login() : Admin3;
}

class User3 implements UserAuthInterface
{
    public static function login() : self
    {
        return new self;
    }
}

class Admin3 implements AdminAuthInterface
{
    public static function login() : self
    {
        return new self;
    }
}

assert(User3::login() instanceof User3);
assert(Admin3::login() instanceof Admin3);
