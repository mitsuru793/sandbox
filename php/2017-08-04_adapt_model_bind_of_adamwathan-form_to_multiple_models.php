<?php
/*
adamwathan/formのモデルへのbindを、複数モデルに対応させる。

inputのname属性には`user[0][name]`とは書けないため、`name[]`と書く。
レコードのカラム値以外の値が混ざると対応できない。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

use AdamWathan\Form\FormBuilder;

function main()
{
    if (empty($_POST)) {
        $users = createUser(5);
        $msg = 'Create Users';
    } else {
        $users = User::createMany(convertPerColumnToRecord($_POST));
        $msg = 'Update Users';
    }
    $userForm = new UserForm($users);
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
    <h3><?=$msg?></h3>
    <?=$userForm?>
    <h3>posted data before</h3>
    <? dump($_POST) ?>
</body>
</html>
    <?
}

/**
 * ['name' => ['Adrain Cruickshank', ...], 'age' => [33, ...]]
 * 下記に変換
 * [['name' => ['Adrain Cruickshank'], 'age' => 33], ...]
 */
function convertPerColumnToRecord(array $inputs) : array
{
    $columns = array_keys($inputs);
    $records = array_reduce($inputs, function ($records, $values) use (&$columns) {
        $column = array_shift($columns);
        foreach ($values as $i => $val) {
            $records[$i][$column] = $val;
        }
        return $records;
    });
    return $records;
}

class User
{
    public $name;
    public $age;
    public $email;
    public $date_of_birth;

    public static function create(array $data) : self
    {
        $user = new self;
        foreach ($data as $key => $val) {
            if (property_exists($user, $key)) {
                $user->$key = $val;
            }
        }
        return $user;
    }

    public static function createMany(array $dataList) : array
    {
        $users = [];
        foreach ($dataList as $data) {
            $users[] = static::create($data);
        }
        return $users;
    }
}

class UserForm
{
    private $users;
    private $builder;

    public function __construct(array $users)
    {
        $this->users = $users;
        $this->builder = new FormBuilder;
    }

    public function __toString() : string
    {
        return $this->table();
    }

    private function table() : string
    {
        ob_start();
        ?>
        <?=$this->builder->open()->post()->action($_SERVER['REQUEST_URI'])?>
        <table>
            <thead>
                <tr>
                    <th>name</th>
                    <th>age</th>
                    <th>email</th>
                    <th>date of birth</th>
                </tr>
            </thead>
            </tbody>
                <?=$this->rows()?>
            <tbody>
            </tbody>
        </table>
        <?=$this->builder->submit('Update');?>
        <?=$this->builder->close()?>
        <?
        return ob_get_clean();
    }

    private function rows() : string
    {
        $out = '';
        foreach ($this->users as $user) {
            $out .= $this->row($user);
        }
        return $out;
    }

    private function row($user) : string
    {
        $this->builder->bind($user);

        ob_start();
        ?>
        <?=$this->builder->open()->post()->action($_SERVER['REQUEST_URI'])?>
        <tr>
            <td><?=$this->builder->text("name[]")->min(5)->required()?></td>
            <td><?=$this->builder->text('age[]')?></td>
            <td><?=$this->builder->email('email[]')?></td>
            <td><?=$this->builder->date('date_of_birth[]')?></td>
        </tr>
        <?
        return ob_get_clean();
    }
}

function createUser(int $createNum) : array
{
    $faker = Faker\Factory::create();
    return collect(range(0, $createNum))->map(function () use ($faker) {
        return User::create([
            'name' => $faker->name,
            'age' => $faker->numberBetween(0, 100),
            'email' => $faker->email,
            'date_of_birth' => $faker->date,
        ]);
    })->all();
}

main();
