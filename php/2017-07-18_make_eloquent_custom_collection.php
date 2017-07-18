<?php
/*
laravelのEloquentでカスタムコレクションを作る。
*/
require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

$capsule = new Capsule;
$capsule->addConnection(require_once __DIR__ . '/Lib/DB/config.php');
$capsule->setAsGlobal();
$capsule->bootEloquent();

$schema = Capsule::schema();
$schema->dropIfExists('users');
$schema->create('users', function ($table) {
    $table->increments('id');
    $table->string('name')->unique();
    $table->timestamps();
});

class User extends Model
{
    // すべてのカラムの複数代入を許可する
    protected $guarded = [];

    public function newCollection(array $models = [])
    {
        return new Users($models);
    }
}

class Users extends Collection
{
    /**
     * Suzukiさんを抽出する。
     */
    public function suzuki()
    {
        $items =  array_filter($this->items, function ($user) {
            return preg_match('/^suzuki/i', $user->name);
        });
        return new static($items);
    }
}

User::create(['name' => 'Suzuki Hanako']);
User::create(['name' => 'Suzuki Taro']);
User::create(['name' => 'Yamada Yumi']);
$users = User::all();
assert($users instanceof Users);

// listを使えば、モデルではなくカラム値で受け取れる。
[$p1, $p2] = $users->suzuki()->pluck('name');
assert($p1 === 'Suzuki Hanako');
assert($p2 === 'Suzuki Taro');
