<?php
/*
`__get`を上書きしても、Collectionはアクセス自体しないので意味がない。
*/
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Collection;
use function Lib\puts;

class Users extends Collection
{
}

class User
{
    private $name;
    private $age;

    public function __construct(string $name, int $age)
    {
        $this->name = $name;
        $this->age = $age;
    }

    public function age()
    {
        return $this->age;
    }
}

$users = new Users([
    new User('Jane', 20),
    new User('Mike', 18),
    new User('Michelle', 25),
]);

// 内部のdata_get()はisset($target->{$segment})でアクセス可能かを確認しているためエラーが起きない。
// アクセス出来ない場合は、引数3の$defaultが返る。
$sorted = $users->sortBy('age');
dump($sorted);

$sorted = $users->sortBy(function ($v) {
    return $v->age();
});
dump($sorted);

// __getを上書きしても、そもそもプロパティにアクセス出来ないときは、アクセスしないようになっているため意味がない。
class User2
{
    public $name;
    private $age;

    public function __construct(string $name, int $age)
    {
        $this->name = $name;
        $this->age = $age;
    }

    public function __get(string $name)
    {
        if (!property_exists($this->{$name})) {
            throw new Exception("Property [{$key}] does not exist on this instance.");
        }
        return $this->{$name};
    }

    public function age()
    {
        return $this->age;
    }
}

$users = new Users([
    new User2('Jane', 20),
    new User2('Mike', 18),
    new User2('Michelle', 25),
]);

$sorted = $users->sortBy('age');
dump($sorted);
