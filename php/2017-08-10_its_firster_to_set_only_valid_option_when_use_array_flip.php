<?php
/*
許容されたオプションのみをセットする場合は、array_flipを使うと速い。
*/
// thanks: https://github.com/symfony/http-foundation/blob/f8f70d6b02654e48cf4a210311d6dedd0afbf980/Session/Storage/NativeSessionStorage.php

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

function setOption(array $options) : array
{
    $user = [];
    $validOptions = array_flip([
        'name', 'age',
    ]);

    foreach ($options as $key => $value) {
        if (isset($validOptions[$key])) {
            $user[$key] = $value;
        }
    }
    return $user;
}

dump(setOption([
    'name' => 'Mike',
    'age' => 19,
    'email' => 'mike@gmail.com',
]));
