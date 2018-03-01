<?php
/*
ファイル名の先頭に今日の日付をつけて、タイトルを変える。拡張子は変更しない。

```
script tmp.php hello world
tmp.php -> 2017-07-17_hello_world.php
```
*/

if (count($argv) < 3) {
    throw new ArgumentCountError('Arguments must be more than 2');
}

$file  = $argv[1];
$ext = pathinfo($file, PATHINFO_EXTENSION);
$title = implode('_', array_slice($argv, 2));
$newName = date('Y-m-d') . '_' . $title . ".$ext";
rename($file, $newName);
