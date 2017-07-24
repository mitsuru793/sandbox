<?php
/*
in_arrayを使うより、連想配列にissetを使うほうが18倍速い。
*/
require __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

const MAX = 10000;
$faker = Faker\Factory::create();
$result = [];

/********/
/* 配列 */
/********/

$names = [];
for ($i = 0; $i < MAX; $i++) {
    $names[] = $faker->name;
}
$names = collect($names)->unique()->values()->all();
$target = collect($names)->last();

$start = microtime(true);
assert(in_array($target, $names));
$result['array'] = microtime(true) - $start;

/************/
/* 連想配列 */
/************/
$names2 = [];
foreach ($names as $name) {
    $names2[$name] = $name;
}
assert(count($names) === count($names2));

$start = microtime(true);
assert(isset($names2[$target]));
$result['hash'] = microtime(true) - $start;

/********/
/* 結果 */
/********/
assert($result['array'] - $result['hash'] > 0);

foreach ($result as $name => $time) {
    puts("$name:\t$time");
}

$diff = $result['array'] - $result['hash'];
puts("diff:\t$diff");

$ratio = $result['array'] / $result['hash'];
puts("ratio:\t$ratio");

/*
array:  3.504753112793E-5
hash:   1.9073486328125E-6
diff:   3.3140182495117E-5
18.375: 18.375
*/
