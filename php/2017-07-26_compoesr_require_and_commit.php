<?php
/*
composer requireしてコミットする。

`php script 'person/libname'`
*/

$libName = $argv[1];
git('stash');

exec("composer require $libName");
git('add composer.json');
git('add composer.lock');
git("commit -m \"composer require '$libName'\"");

git("stash pop");

function git(string $command)
{
    exec("git $command");
}
