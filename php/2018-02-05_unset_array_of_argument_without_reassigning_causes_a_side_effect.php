<?php
/*
引数の配列は、再代入してからunsetしないと副作用が出る。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

class User
{
    public $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function remove1($key)
    {
        $removed = $this->data;
        unset($removed[$key]);
        return $removed;
    }

    public function remove2($key)
    {
        unset($this->data[$key]);
        return $this->data;
    }
}

$user = new User(['name' => 'mike', 'age' => 20]);
assert($user->data['age'] === 20);

$removed = $user->remove1('age');

assert(array_key_exists('age', $user->data));
assert(!array_key_exists('age', $removed));

$removed = $user->remove2('age');
assert(!array_key_exists('age', $user->data));
assert(!array_key_exists('age', $removed));
