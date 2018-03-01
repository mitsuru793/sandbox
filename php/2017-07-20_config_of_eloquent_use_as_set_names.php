<?php
/*
EloquentのconfigのcharsetはSET NAMESの代わりになる。

[MySQL :: MySQL 5\.6 リファレンスマニュアル :: 10\.1\.4 接続文字セットおよび照合順序](https://dev.mysql.com/doc/refman/5.6/ja/charset-connection.html)
*/

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\MySqlConnection;

$baseConfig = require_once __DIR__ . '/Lib/DB/config.php';

$capsule = new Capsule;
$capsule->setAsGlobal();
// arg2でコネクション名を指定しない場合は'default'になる。
// default値は絶対に必要。
$capsule->addConnection($baseConfig);

/**********************************************************************/
/* デフォルト値ではないtis620で、SET NAMESと同じカラムが変更されるか? */
/**********************************************************************/
$config = array_merge($baseConfig, [
    'charset' => 'tis620'
]);
// collationを設定しない場合はcharsetに対応したデフォルト値になる。
unset($config['collation']);
$capsule->addConnection($config, 'case1');
$connection = $capsule->getConnection('case1');
testCharset($connection, 'tis620');
testCollation($connection, 'tis620');

/**********************************************************/
/* utf8mb4とその照合順序のデフォルト値以外に設定できるか? */
/**********************************************************/
$config = array_merge($baseConfig, [
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_general_ci',
]);
$capsule->addConnection($config, 'case2');
$connection = $capsule->getConnection('case2');
testCharset($connection, 'utf8mb4');
testCollation($connection, 'utf8mb4_general_ci');

/**
 * SET NAMESで影響するcharacter_setの設定値が、$targetCharsetに変更されたか？
 */
function testCharset(MySqlConnection $connection, string $targetCharset) : void
{
    // SET NAMESで設定されるもの
    $targetSettings = [
        'character_set_client',
        'character_set_connection',
        'character_set_results',
    ];

    $charSets = $connection->select("SHOW VARIABLES LIKE 'character_set%'");
    $wasAllTargetChanged = collect($charSets)
        ->whereIn('Variable_name', $targetSettings)
        ->every(function($charSet) use ($targetCharset){
            return $charSet->Value == $targetCharset;
        });
    assert($wasAllTargetChanged);
}

/**
 * SET CHAR NAMESで影響するcharacter_setの設定値が、$targetCharsetに変更されたか？
 */
function testCollation(MySqlConnection $connection, string $targetCollation) : void
{
    $collations = $connection->select("SHOW VARIABLES LIKE 'collation%'");
    $collation = collect($collations)
        ->where('Variable_name', 'collation_connection')
        ->first()->Value;
    assert(preg_match("/$targetCollation/", $collation));
}
