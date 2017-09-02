<?php
/*
dot記法を実現するヘルパー関数data_getを読む
*/

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Arr;

$people = [
    'japan' => [
        'taro' => [
            'age' => 22,
            'sex' => 'man',
        ],
        'hanako' => [
            'age' => 18,
            'sex' => 'woman',
        ],
    ],
    'us' => [
        'mike' => [
            'age' => 24,
            'sex' => 'man',
        ],
    ],
];

// 階層2、人名を含んで取得。
print_r(data_get($people, '*'));

// 階層3、各要素はageとsexのみ
print_r(data_get($people, '*.*'));

// [22, man, 18, wooman, 24, man]
print_r(data_get($people, '*.*.*'));

// [22, man]
print_r(data_get($people, 'japan.taro.*'));

print_r(data_get($people, '*.*.age'));

/**
 * Get an item from an array or object using "dot" notation.
 *
 * @param  mixed   $target
 * @param  string|array  $key
 * @param  mixed   $default
 * @return mixed
 */
function data_get($target, $key, $default = null)
{
    // arg2は省略はできないが、nullを渡すことは可能。
    // スカラ値ではなく変数が渡る時に、nullの場合があるかもしれないことを考慮。
    if (is_null($key)) {
        return $target;
    }

    // keyをスタックとして使用するので配列に変換。
    $key = is_array($key) ? $key : explode('.', $key);

    // 先頭のkey値から取り出す。
    while (($segment = array_shift($key)) !== null) {
        if ($segment === '*') {
            if ($target instanceof Collection) {
                $target = $target->all();
            } elseif (! is_array($target)) {
                // 配列ではないということは単一の値。クロージャーの場合は戻り値を返す。
                return value($default);
            }

            // $targetは配列であることが保証される。
            // *により全要素から$keyを取得する必要があるため、pluckを使っている。
            $result = Arr::pluck($target, $key);

            // *が2回使われていたら、次の階層の要素を展開する。
            return in_array('*', $key) ? Arr::collapse($result) : $result;
        }

        // accessibleは添え字でアクセス出来る値かを見ている。
        if (Arr::accessible($target) && Arr::exists($target, $segment)) {
            $target = $target[$segment];
        } elseif (is_object($target) && isset($target->{$segment})) {
            $target = $target->{$segment};
        } else {
            return value($default);
        }
    }

    return $target;
}
