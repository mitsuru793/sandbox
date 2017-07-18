<?php
/*
Eloquentでテーブル名と違う名前でモデルを作り、関連テーブルから参照する。
*/
require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model;

$capsule = new Capsule;
$capsule->addConnection(require_once __DIR__ . '/Lib/DB/config.php');
// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();
// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
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
    $table->string('title');
    $table->timestamps();
});

// usersテーブルをpersonsとして使用する。
class Person extends Model
{
    protected $table = 'users';
    protected $guarded = [];

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
        return $this->belongsTo('Person');
    }

    public function person()
    {
        // person_idではないため、user_idを指定。
        // このpersonはメソッド名が使われている。
        // そのため毎回belongsToを使うたびに指定する必要がある。
        return $this->belongsTo('Person', 'user_id');
    }
}

$taro = Person::create(['name' => 'taro']);
$taro->posts()->createMany([
    ['title' => 'from taro 1'],
    ['title' => 'from taro 2'],
]);

$hanako = Person::create(['name' => 'hanako']);
$hanako->posts()->create(['title' => 'from hanako 1']);

$taroPosts1 = Post::whereHas('user', function ($query) {
    $query->where('name', 'like', '%taro%');
})->get();

$taroPosts2 = Post::whereHas('person', function ($query) {
    $query->where('name', 'like', '%taro%');
})->get();
assert($taroPosts1->toArray() === $taroPosts2->toArray());

assert(Post::all()->count() === 3);
assert($taroPosts1->count() === 2);

[$p1, $p2] = $taroPosts1;
assert($p1->title === 'from taro 1');
assert($p2->title === 'from taro 2');
