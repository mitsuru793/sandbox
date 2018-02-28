<?php
/*
PDOStatementでinsertを実行しても、挿入レコードをfetchできない。
*/
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use function Lib\puts;
use function Lib\makePDO;

$pdo = makePDO();

$res = $pdo->exec(<<<'SQL'
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `age` SMALLINT NOT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `users` (`name`, `age`) VALUES ('taro', 10);
SQL
);
assert($res === 0);

$res = $pdo->exec("INSERT INTO `users` (`name`, `age`) VALUES ('hanako', 20);");
assert($res === 1);

$stmt = $pdo->query('SELECT * FROM `users`;');
assert($stmt->rowCount() === 2);

$stmt = $pdo->prepare("INSERT INTO `users` (`name`, `age`) VALUES ('jane', 20);");
assert($stmt->execute() === true);
assert($stmt->fetch() === false);
assert($stmt->fetchAll() === []);
