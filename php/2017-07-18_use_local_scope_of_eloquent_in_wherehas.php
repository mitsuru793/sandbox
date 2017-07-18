<?php
/*
EloquentのローカルスコープはwhereHasのクロージャの中でも使える。
*/
require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model;

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

$schema->dropIfExists('posts');
$schema->create('posts', function ($table) {
    $table->increments('id');
    $table->integer('user_id');
    $table->integer('views')->default(0);
    $table->string('title')->unique();
    $table->timestamps();
});

class User extends Model
{
    protected $guarded = [];

    protected $table = 'users';
    public function posts()
    {
        return $this->hasMany('Post', 'user_id');
    }
}

class Post extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('Person', 'user_id');
    }

    public function scopeMoreThan3Views($query)
    {
        return $query->where('views', '>', 3);
    }
}

$taro = User::create(['name' => 'taro']);

// 作成したモデルのコレクションが返ります。
$posts = $taro->posts()->createMany([
    ['title' => 'Hello1', 'views' => 1],
    ['title' => 'Hello2', 'views' => 2],
    ['title' => 'Hello3', 'views' => 3],
    ['title' => 'Hello4', 'views' => 4],
    ['title' => 'Hello5', 'views' => 5],
]);
// postが作成できたことを確認
assert($posts->every(function ($post, $key) {
    return $post->id == ($key + 1);
}));

// ローカルスコープが使えている
[$p4, $p5] = Post::moreThan3Views()->get();
assert($p4->views === 4);
assert($p5->views === 5);

// 関連テーブルからもローカルスコープが使える。
[$p4, $p5] = $taro->posts()->moreThan3Views()->get();
assert($p4->views = 4);
assert($p5->views = 5);

// 別ユーザーとそのポストも追加して、フィルタリングをテストする。
$hanako = User::create(['name' => 'hanako']);
$hanako->posts()->create(['title' => 'Hello6', 'views' => 1]);

$users = User::whereHas('posts', function ($query) {
    // レシーバーがユーザーのため、3 viewsより多いポストを持つtaroだけを取得する。
    $query->moreThan3Views();
})->get();
assert($users->count() === 1);
assert($users->first()->name === 'taro');
