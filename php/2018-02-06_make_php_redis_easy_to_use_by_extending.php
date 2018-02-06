<?php
/*
PhpRedisを拡張して使いやすくする
*/
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

final class Rds extends Redis
{
    public function __construct()
    {
        parent::__construct();
    }

    public static function create(string $prefix = '', string $host = '127.0.0.1', int $port = 6379, float $timeout = 0): ?self
    {
        $rds = new self();
        if (!@$rds->connect($host, $port, $timeout)) {
            return null;
        }

        // prefixを設定できる。設定するとデータは消える
        $rds->setOption(Redis::OPT_PREFIX, $prefix);
        return $rds;
    }

    public function active(): bool
    {
        try {
            @$this->ping(); // '+PONG'以外の戻り値が返るかは不明
            return true;
        } catch (RedisException $e) {
            // error message list
            // 'Redis server went away': connect()を実行していない;
            // 'Connection lost': connect()にserverが落ちた
            return false;
        }
    }

    public function setInSecond(string $key, int $ttlSecond, string $value): bool
    {
        return $this->setex($key, $ttlSecond, $value);
    }

    public function hIncr(string $key, string $hashKey): int
    {
        return $this->hIncrBy($key, $hashKey, 1);
    }

    // suffix Allのメソッドで1回のトランザクションにまとめる
    public function expireAll(array $keys, int $second): array
    {
        $multi = $this->multi(Redis::PIPELINE);
        foreach ($keys as $key) {
            $multi->expire($key, $second);
        }
        return $multi->exec();
    }

    // パイプラインのラッパー。動的なので無くても良い。
    public function transaction(string $method, array $argsList): array
    {
        $multi = $this->multi(Redis::PIPELINE);
        foreach ($argsList as $args) {
            $multi->{$method}(...$args);
        }
        return $multi->exec();
    }
}

$rds = Rds::create('sandbox:');
assert($rds->active());

$rds->hset('user', 'age', 19);
$rds->hIncr('user', 'age');
assert($rds->hGet('user', 'age') === '20');
assert($rds->keys('*') === ['sandbox:user']);

assert($rds->expireAll(['user', 'missing'], 3) === [true, false]);

$returned = $rds->transaction('expire', [
    ['user', 2],
    ['missing', 2],
]);
assert($returned === [true, false]);

$rds->flushAll();
