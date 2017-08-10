<?php
/*
オブジェクトのプロパティの更新に間隔を設けて制限する
*/

// thanks: https://github.com/symfony/http-foundation/blob/d7b31206638f0d9492679e5a525e4f2abf7a990b/Session/Storage/MetadataBag.php

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

class User
{
    const CREATED = 'c';
    const UPDATED = 'u';

    protected $meta = [
        self::CREATED => 0,
        self::UPDATED => 0,
    ];

    protected $data = [
        'name' => null,
        'age' => null,
    ];

    // threshold: 閾
    // プロパティを更新できる間隔(秒単位)
    protected $updateThreshold;

    public function __construct(int $updateThreshold = 0)
    {
        $this->meta[self::CREATED] = time();
        $this->updateThreshold = $updateThreshold;
    }

    public function __set(string $name, $value)
    {
        $timeStamp = microtime(true);
        if ($timeStamp - $this->meta[self::UPDATED] >= $this->updateThreshold) {
            // 前回の更新より、指定時間を経過した。
            $this->meta[self::UPDATED] = $timeStamp;
            $this->data[$name] = $value;
        }
    }

    public function __get(string $name)
    {
        return $this->data[$name];
    }

    public function meta() : array
    {
        return $this->meta;
    }
}

$user = new User(1);
$user->name = 'mike';
assert($user->name === 'mike');

$user->name = 'jane';
assert($user->name === 'mike');

sleep(1);
$user->name = 'jane';
assert($user->name === 'jane');
