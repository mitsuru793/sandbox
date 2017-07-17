<?php
/*
引数の型にnullableを指定しても、省略はできない。
省略する場合はデフォルト値を指定する。nullでなくてもいい。
*/

function nullable(?string $s) {}

nullable(null);
nullable('');
try {
    nullable();
} catch (Error $e) {
    assert(preg_match(
        '/Too few arguments to function nullable/',
        $e->getMessage()
    ));
}

function both(?string $s = null) {}

both(null);
both('');
both();
