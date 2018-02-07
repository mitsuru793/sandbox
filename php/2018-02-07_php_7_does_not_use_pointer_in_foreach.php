<?php
/*
PHP7でforeachでポインタが使われなくなったことを確認する

`end()`の後に`reset()`を呼び出す必要はなくなった。
[PHPのforeachで参照渡しを使ったときの落とし穴 \- Qiita](https://qiita.com/ttskch/items/c6d8ea00c57640c52cd8)
*/
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

$nums = [1,2,3];

assert(end($nums) === 3);

foreach ($nums as $num) {
    puts((string)$num);
}
// 1
// 2
// 3

foreach ($nums as $$num) {
    puts((string)$num);
}
// 3
// 3
// 3

foreach ($nums as $num) {
    puts((string)$num);
}
// 1
// 2
// 3
