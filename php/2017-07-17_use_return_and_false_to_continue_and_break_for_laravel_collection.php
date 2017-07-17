<?php
/*
laravelのCollection->eachでcontinue, breakするにはreturnとfalseを使う。
*/

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Collection;

$nums = [1, 2, 3];

$result = [];
collect($nums)->each(function ($item) use (&$result){
    if ($item === 1) {
        // contineの代わりにreturnを使う。
        // mapではないので空要素は入らない。
        return;
    }
    $result[] = $item;
});
assert($result === [2, 3]);

$result = [];
collect($nums)->each(function ($item) use (&$result){
    if ($item === 2) {
        // breakの代わりにfalseを返す。
        return false;
    }
    $result[] = $item;
});
assert($result === [1]);
