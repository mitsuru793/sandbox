<?php
/*
laravelのcollectionのwhenは真の時のみ、collectionを受取り加工する。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;
use Illuminate\Support\Collection;

function calc(array $nums, string $way): array
{
    return collect($nums)
    ->when($way === 'increment', function ($nums) {
        return $nums->map(function ($num) { return $num + 1; });
    })
    ->when($way === 'double', function ($nums) {
        return $nums->map(function ($num) { return $num * 2; });
    })->toArray();
}

assert(calc([1,2,3], 'increment') === [2,3,4]);
assert(calc([1,2,3], 'double') === [2,4,6]);
assert(calc([1,2,3], 'missing') === [1,2,3]);
