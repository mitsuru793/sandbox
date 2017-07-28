<?php
/*
laravelのDBManagerの起動は、通常のPDOの生成より4~10倍かかる。

Laravelのは2度目以降の起動はPHPスクリプトを一度終わらせる必要がある？
1つのスクリプト内でループさせてテストはできなさそう。
*/

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Events\Dispatcher;
use function Lib\puts;
use function Lib\execTime;

run();

function run()
{
    $config = require_once __DIR__ . '/Lib/DB/config.php';
    $managerTime = execTime(function () use ($config) {
        makeDBManager($config);
    });

    $pdoTime = execTime(function () use ($config) {
        makePDO($config);
    });

    $diff = $managerTime - $pdoTime;
    $ratio = $managerTime / $pdoTime;

    puts("laravel $managerTime");
    puts("pdoTime $pdoTime");
    puts("diff    $diff");
    puts("ratio   $ratio");
}

function makeDBManager(array $config)
{
    $capsule = new Capsule;
    $capsule->addConnection($config);
    $dispatcher = new Dispatcher;
    $dispatcher->listen(StatementPrepared::class, function ($event) {
        $event->statement->setFetchMode(PDO::FETCH_ASSOC);
    });
    $capsule->setEventDispatcher($dispatcher);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();
}

function makePDO(array $config, $options = [])
{
    $dsn = sprintf('%s:host=%s;dbname=%s', $config['driver'], $config['host'], $config['database']);
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ] + $options;
    return new PDO($dsn, $config['username'], $config['password'], $options);
}
