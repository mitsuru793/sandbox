<?php
/*
配列のプロパティを初期化する時に、クラス定数が使える。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

class DevelopmentUsers
{
    private const Mike_ID  = '1234';
    private const Jane_ID  = '5678';

    public $settings = [
        self::Mike_ID => 'Setting 1',
        self::Jane_ID => 'Setting 2'
    ];
}

$users = new DevelopmentUsers;
dump($users->settings);
