<?php
namespace Lib;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\MySqlBuilder;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Illuminate\Database\Events\StatementPrepared;
use Lib\Stringy;
use PDO;

function create($str, $encoding = null)
{
    return new Stringy($str, $encoding);
}

function puts(string $str, $level = 0, $indent = '    ')
{
    $out = '';
    $lines = explode(PHP_EOL, $str);
    foreach ($lines as $line) {
        if ($level > 0) {
            for ($i = 0; $i < $level; $i++) {
                $out .= $indent;
            }
        }
        $out .= $line . PHP_EOL;
    }
    echo $out;
}

function execTime(callable $fn, int $num = 1) : float
{
    $start = microtime(true);
    for ($i = 0; $i < $num; $i++) {
        $fn();
    }
    return microtime(true) - $start;
}

function putsExecTime(callable $fn, int $num = 1, $level = 0, $indent = '    ') : void
{
    puts(execTime($fn, $num), $level, $indent);
}

function makeLaravelSqlBuilder(array $config = []) : MySqlBuilder
{
    if (empty($config)) {
        $config = require_once __DIR__ . '/DB/config.php';
    }

    $capsule = new Capsule;

    // Laravel5.4からはイベントリスナーでフェッチモードを変更
    $dispatcher = new Dispatcher;
    $dispatcher->listen(StatementPrepared::class, function ($event) {
        $event->statement->setFetchMode(PDO::FETCH_ASSOC);
    });

    $capsule->addConnection($config);
    $capsule->setEventDispatcher($dispatcher);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();
    return Capsule::schema();
}

function makePDO(array $config = [], $options = [])
{
    if (empty($config)) {
        $config = require_once __DIR__ . '/DB/config.php';
    }

    $ops = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];
    foreach ($options as $key => $value) {
        $ops[$key] = $value;
    }
    $dsn = sprintf('%s:host=%s;dbname=%s', $config['driver'], $config['host'], $config['database']);
    return new PDO($dsn, $config['username'], $config['password'], $options);
}
