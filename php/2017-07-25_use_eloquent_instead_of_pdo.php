<?php
/*
PDOのメソッドをEloquentで代用する。

Eloquentのメソッドを使うとデバッグのログが取れるのが良い。
だがgetPdoを使うのが速い。
*/
require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\MySqlBuilder;
use Illuminate\Events\Dispatcher;
use Illuminate\Database\Events\StatementPrepared;

function main()
{
    $config = require_once __DIR__ . '/Lib/DB/config.php';
    $laraBuilder = makeLaravelSqlBuilder($config);
    createUserTable($laraBuilder);

    $pdo = makePDO($config);

    $sql = "SELECT * FROM users";

    $statement = $pdo->prepare($sql);
    assert($statement instanceof PDOStatement);
    assert($statement->execute([]) === true);


    /****************************************/
    /* keyの並びは同じだが、valueの型が違う */
    /****************************************/
    $laraRows = Capsule::select($sql);
    $pdoRows = $statement->fetchAll(PDO::FETCH_ASSOC);
    assert(count($laraRows) === 2);
    assert(count($pdoRows) === 2);

    $laraRow = $laraRows[0];
    $pdoRow = $pdoRows[0];
    assertSame(array_keys($laraRow), array_keys($pdoRow));

    // laravelだとvalueが文字列ではなく自動でキャストされる。
    assert(is_int($laraRow['id']));
    assert(is_int($laraRow['age']));
    assert(is_string($pdoRow['id']));
    assert(is_string($pdoRow['age']));


    /****************************************/
    /* fetchColumnはfirst, valuesで代用する */
    /****************************************/
    // PDOはもう一度execしないと再度カラムを取得できない。
    assert($statement->fetchColumn() === false);
    $statement->execute();
    assert($statement->fetchColumn() === '1');
    assert(collect(Capsule::selectOne($sql))->first() === 1);

    $statement->execute();
    assert($statement->fetchColumn(1) === 'Hanako');
    assert(collect(Capsule::selectOne($sql))->values()[1] === 'Hanako');


    /****************************************/
    /* fetchColumnはfirst, valuesで代用する */
    /****************************************/
    // 一度insertしないといけない。
    assert($pdo->lastInsertId() === '0');
    $pdo->exec("INSERT INTO users (name, age) VALUES ('new', 100)");
    assert($pdo->lastInsertId() === '3');

    // Eloquentは保存するとlastInsertIdが入ったモデルが手に入る。
    $user = User::create(['name' => 'new2', 'age' => '200']);
    assert($user->id === 4);

    // テーブル名が分かり、モデル名分からない時。
    $laraPdo = Capsule::getPdo();
    assert($laraPdo->lastInsertId() === '4');

    /****************************************/
    /* rowCountはdeleteなどの戻り値で取得   */
    /****************************************/

    $statement = $pdo->prepare('DELETE FROM users WHERE id IN (?, ?)');
    assert($statement->execute([1, 2]) === true);
    // これはstirngではなくint
    assert($statement->rowCount() === 2);

    assert(Capsule::update("UPDATE  users set name = 'same'") === 2);
    assert(Capsule::delete('DELETE FROM users WHERE id IN (3, 4)') === 2);
}

function assertSame($a, $b)
{
    assert($a === $b);
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

function makePDO(array $config, array $options = []) : PDO
{
    $dsn = sprintf('%s:host=%s;dbname=%s', $config['driver'], $config['host'], $config['database']);
    $options = array_merge([
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ], $options);
    return new PDO($dsn, $config['username'], $config['password'], $options);
}

main();
