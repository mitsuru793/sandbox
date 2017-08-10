<?php
/*
公開するプロパティと非公開のメタデータを、どちらもprotectedプロパティで管理する。

`__set`を通して、publicプロパティとしてアクセスしてもセッターを呼び出すことが出来る。
jsonで書き出す時は$dataのみを対象とすれば良いので楽。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;


class User
{
    protected $data = [];
    protected $meta = [];

    public function __construct()
    {
        $this->meta['createdAt'] = time();
    }

    public function __set($name, $value)
    {
        $setter = "set{$name}Attribute";
        if (method_exists($this, $setter)) {
            $value = $this->$setter($value);
        }
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        return $this->data[$name];
    }

    public function data()
    {
        return $this->data;
    }

    public function meta()
    {
        return $this->meta;
    }

    private function setAgeAttribute($value)
    {
        return ($value > 20 ? 12 : $value);
    }
}

$user = new User;
$user->name = 'Mike';
$user->age = 30;
assert(is_int($user->meta()['createdAt']));
assert($user->data() === ['name' => 'Mike', 'age' => 12]);
