<?php
/*
配列のネストした要素も含めて、全体のカラム数を調べる。
*/
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

$user = [
    'id',
    'user' => [
        'name',
        'age',
        'family' => [
            'man',
            'woman'
        ],
    ],
];

function array_count_column(int $rowCount, array $columns): int
{
    foreach ($columns as $key => $value) {
        if (is_int($key)) {
            $rowCount++;
        } else {
            // 連想配列(子ヘッダーを持つ場合)
            $rowCount = array_count_column($rowCount, $value);
        }
    }
    return $rowCount;
}

echo array_count_column(0, $user);
