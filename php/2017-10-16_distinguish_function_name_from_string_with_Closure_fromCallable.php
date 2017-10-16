<?php
/*
Closure::fromCallableで関数名と文字列を区別する

下記の記事によるとlaravelのCollectionのメソッドに、グローバル関数をclosureとして渡せるとある。
しかし、is_floatだと引数が2つ渡るから警告が出る。
[Joseph Silber](https://josephsilber.com/posts/2016/07/13/closure-from-callable-in-php-7-1#table-of-contents)
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

$numbers = collect([1, 1.5, 2, 'is_float']);

$actual = $numbers->reject('is_float')->values()->all();
assert([1, 1.5, 2] === $actual);

$actual = $numbers->reject(function ($num) {
    return is_float($num);
})->values()->all();
assert([1, 2, 'is_float'] === $actual);

$is_float = Closure::fromCallable('is_float');
assert(is_callable($is_float));
assert($is_float instanceof Closure);

// Warning: is_float() expects exactly 1 parameter, 2 given in /Users/mitsuru/code/sandbox/php/vendor/illuminate/support/Collection.php on line 1095
$actual = $numbers->reject($is_float)->values()->all();
assert([1, 1.5, 2, 'is_float'] === $actual);
