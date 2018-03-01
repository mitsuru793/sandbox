<?php
/*
Eloquentのcreateの戻り値は、指定していないカラム値が代入されていない。

DB側のDefault値などは入っていない。INSERT時にSELECTは走っていない。
createでINSERTとSELECTの2回、IOが発生するのか気になったが1回だった。
*/
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\MySqlBuilder;
use function Lib\makeLaravelSqlBuilder;

function main()
{
    $config = require_once __DIR__ . '/Lib/DB/config.php';

    $sqlBuilder = makeLaravelSqlBuilder($config);
    createUserTable($sqlBuilder);

    Capsule::enableQueryLog();
    $user = User::create();
    $logs = Capsule::getQueryLog();

    assert(count($logs) === 1);
    assert($logs[0]['query'] === 'insert into `users` (`updated_at`, `created_at`) values (?, ?)');

    assert($user->name === null);
    assert($user->age === null);

    $user = User::find($user->id);
    assert($user->name === 'nanashi');
    assert($user->age === null);

    // デフォルト値を設定してもnullは許容されない
    // User::create(['name' => null]);
}

function createUserTable(MySqlBuilder $schema) : void
{
    $schema->dropIfExists('users');
    $schema->create('users', function ($table) {
        $table->increments('id');
        $table->string('name')->default('nanashi');
        $table->integer('age')->nullable();
        $table->timestamps();
    });
}

class User extends Model
{
    protected $table = 'users';

    // すべてのカラムの複数代入を許可する
    protected $guarded = [];

    public function toDomain(): User
    {
        return User::create($this->toArray());
    }
}

main();
