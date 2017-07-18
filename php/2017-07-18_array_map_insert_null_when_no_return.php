<?php
/*
array_mapでreturnを書かない場合は、nullが入る。
*/

$nums = [1,2,3,4];
$filtered = array_map(function ($num) {
    if ($num % 2 == 0) {
        return $num;
    }
}, $nums);
assert($filtered === [null, 2, null, 4]);
