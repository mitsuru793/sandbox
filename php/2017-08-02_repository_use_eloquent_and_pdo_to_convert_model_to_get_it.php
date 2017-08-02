<?php
/*
リポジトリクラスにEloquentとPDOを混在させて、モデルに変換させて取得する。

参考: https://github.com/shin1x1/laravel-ddd-sample
*/

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\MySqlBuilder;
use function Lib\makeLaravelSqlBuilder;

function main()
{
    $config = require_once __DIR__ . '/Lib/DB/config.php';

    $sqlBuilder = makeLaravelSqlBuilder($config);
    createUserTable($sqlBuilder);

    $pdo = new MyPDO($config);
    $repo = new UserRepository($pdo);

    $user = $repo->findById(3);
    dump($user);
    /*
    User {#38
      +id: 3
      +name: "Dr. Raven Ondricka"
    }
    */
    $user = $repo->last();
    dump($user);
}

// ゲッターは省略
class User
{
    public $id;
    public $name;

    private function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
    public static function create(array $row)
    {
        return new self(
            $row['id'],
            $row['name']
        );
    }
}

class UserRepository
{
    private $pdo;
    private $table = 'users';

    public function __construct(MyPDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findById(int $id) : User
    {
        $row = $this->pdo->select("SELECT * FROM `$this->table` WHERE id = $id")[0];
        return User::create($row);
    }

    public function last() : User
    {
        $row = EloquentUser::orderBy('id', 'desc')->first();
        return $row->toDomain();
    }
}

class MyPDO extends PDO
{
    public function __construct(array $config, array $options = [])
    {
        $dsn = sprintf('%s:host=%s;dbname=%s', $config['driver'], $config['host'], $config['database']);
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ] +  $options;
        parent::__construct($dsn, $config['username'], $config['password'], $options);
    }

    public function select(string $sql, array $data = []) : array
    {
        $stmt = $this->prepare($sql);
        $stmt->execute($data);
        return $stmt->fetchAll();
    }
}

function createUserTable(MySqlBuilder $schema) : void
{
    $schema->dropIfExists('users');
    $schema->create('users', function ($table) {
        $table->increments('id');
        $table->string('name');
        $table->timestamps();
    });

    $faker = Faker\Factory::create();
    for ($i = 0; $i < 100; $i++) {
        EloquentUser::create([
            'name' => $faker->name,
        ]);
    }
}

class EloquentUser extends Model
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
