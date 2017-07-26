<?php
/*
laravelで取得したレコードの値を全て文字列に変換する。
*/
require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\MySqlBuilder;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Illuminate\Database\Events\StatementPrepared;

function main()
{
    $config = require_once __DIR__ . '/Lib/DB/config.php';
    $laraBuilder = makeLaravelSqlBuilder($config);
    createUserTable($laraBuilder);
    $users = User::all()->toArray();
    assert(is_int($users[0]['id']));
    assert(is_int($users[0]['age']));
    array_walk_recursive($users, function (&$item, $i) {
        if (!is_string($item) && !is_null($item)) {
            $item = (string)$item;
        }
    });

    assert(is_int($users[0]['id']));
    assert(is_int($users[0]['age']));
    assert(is_int($users[1]['id']));
    assert(is_int($users[1]['age']));
    dump($users);
}

function makeLaravelSqlBuilder(array $config) : MySqlBuilder
{
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

function createUserTable(MySqlBuilder $schema) : void
{
    $schema->dropIfExists('users');
    $schema->create('users', function ($table) {
        $table->increments('id');
        $table->string('name');
        $table->integer('age');
        $table->timestamps();
    });
    User::create(['name' => 'Hanako', 'age' => 20]);
    User::create(['name' => 'Taro', 'age' => 30]);
}

class User extends Model
{
    // すべてのカラムの複数代入を許可する
    protected $guarded = [];
}

main();
