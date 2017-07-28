<?php
/*
mysqlのログファイルで、ATTR_EMULATE_PREPARESが無効の時は2回DBにアクセスすることを確かめる。

bindValueは実行するだけで、mysqlのログファイルに書き込まれます。
*/

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;

$config = require_once __DIR__ . '/Lib/DB/config.php';
$pdo = new MyPDO($config, [
    PDO::ATTR_EMULATE_PREPARES => false,
]);

$pdo->exec(<<<'EOF'
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `age` SMALLINT NOT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `users` (`name`, `age`) VALUES ('taro', 10);
INSERT INTO `users` (`name`, `age`) VALUES ('hanako', 20);
EOF
);

$pdo->exec("SET GLOBAL general_log = 'ON'");

$logFile = tempnam('./', 'mysql-log');
chmod($logFile, 0777);
$pdo->exec("SET GLOBAL general_log_file = '$logFile'");

$id = 1;
$stmt = $pdo->prepare('SELECT * FROM `users` WHERE id = ?');
$stmt->execute([$id]);

// $stmt->bindValue(1, $id, PDO::PARAM_INT);
// $stmt->execute();

dump($stmt->fetch());

$stmt = $pdo->prepare('SELECT count(*) FROM `users`');
$stmt->execute();
dump($stmt->fetchColumn());

puts('-------------------------');
puts(file_get_contents($logFile));

unlink($logFile);

class MyPDO extends PDO
{
    private $dbh;

    public function __construct(array $config, array $options = [])
    {
        $dsn = sprintf('%s:host=%s;dbname=%s', $config['driver'], $config['host'], $config['database']);
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ] +  $options;
        parent::__construct($dsn, $config['username'], $config['password'], $options);
    }

    public function globalOption($option) : string
    {
        $stmt = $this->query("SELECT @@GLOBAL.{$option};");
        $stmt->execute();
        return $stmt->fetch()["@@GLOBAL.{$option}"];
    }
}
