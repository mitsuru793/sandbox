<?php
/*
Eloquentでテーブルを作り、レコードを挿入する。
*/

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model;

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => '127.0.0.1',
    'database'  => 'sandbox',
    'username'  => 'root',
    'password'  => '',
    'port'      => '3306',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

// Set the event dispatcher used by Eloquent models... (optional)
// use Illuminate\Events\Dispatcher;
// use Illuminate\Container\Container;
// $capsule->setEventDispatcher(new Dispatcher(new Container));

// 下記2つはoptionalとあるが必須のようだ。
// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();
// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

$schema = Capsule::schema();
$schema->dropIfExists('users');
$schema->create('users', function ($table) {
    $table->increments('id');
    $table->string('name')->unique();
    $table->integer('age')->default(0);
    $table->timestamps();
});

class User extends Model
{
    // すべてのカラムの複数代入を許可する
    protected $guarded = [];
}

User::create(['name' => 'Yamada', 'age' => 19]);
User::create(['name' => 'Miura']);
