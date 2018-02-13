<?php
/*
Redisのコンストラクタを拡張して接続までする
*/
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

class ExRedis extends Redis
{
    public function __construct(string $prefix = '', string $host = '127.0.0.1', int $port = 6379, float $timeout = 0)
    {
        if (!@$this->connect($host, $port, $timeout)) {
            throw new RuntimeException('connect failed.');
        }
        // prefixを設定できる。設定するとデータは消える
        $this->setOption(Redis::OPT_PREFIX, $prefix);
    }
}

$r = new ExRedis;
$r->flushAll();
assert($r->keys('*') === []);

$r->set('name', 'mike');
assert($r->get('name') === 'mike');
$r->flushAll();
