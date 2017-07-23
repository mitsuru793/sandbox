<?php
/*
ステージングを変更せずに、対象のファイルを1つだけをコミットする。

`php script.php README.md 'first commit'`
*/
require_once __DIR__ . '/vendor/autoload.php';

$filePath = $argv[1];
$message = $argv[2];

$commands = [
    'stash',
    "add $filePath",
    "commit -m '$message'",
    "stash pop",
];
foreach ($commands as $cmd) {
    git($cmd);
}

function git(string $command)
{
    exec("git $command");
}
