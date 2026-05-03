<?php
$host = "db";
$port = 3306;
$user = "user_ci";
$pass = "pass_ci";

try {
  $pdo = new PDO("mysql:host=$host;port=$port", $user, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  ]);
  echo "✓ Connectat al servidor MySQL<br>";

  $pdo->exec(
    "CREATE DATABASE IF NOT EXISTS `esportDaw` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish2_ci",
  );
  echo "✓ Base de dades esportDaw creada<br>";

  $pdo->exec("USE `esportDaw`");

  $pdo->exec("DROP TABLE IF EXISTS `Jugador`");
  $pdo->exec("DROP TABLE IF EXISTS `Equip`");
  echo "✓ Taules antigues eliminades<br>";

  $pdo->exec("CREATE TABLE `Equip` (
      `codiE` int(11) NOT NULL AUTO_INCREMENT,
      `nom` varchar(50) NOT NULL,
      `poblacio` varchar(25) NOT NULL,
      `numSocis` int(11) NOT NULL,
      PRIMARY KEY (`codiE`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci");
  echo "✓ Taula Equip creada<br>";

  $pdo->exec("CREATE TABLE `Jugador` (
      `codiJ` int(11) NOT NULL AUTO_INCREMENT,
      `nom` varchar(20) NOT NULL,
      `cognoms` varchar(30) NOT NULL,
      `demarcacio` varchar(20) NOT NULL,
      `codiE` int(11) NOT NULL,
      PRIMARY KEY (`codiJ`),
      KEY `equip` (`codiE`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci");
  echo "✓ Taula Jugador creada<br>";

  $pdo->exec(
    "ALTER TABLE `Jugador` ADD CONSTRAINT `equip` FOREIGN KEY (`codiE`) REFERENCES `Equip` (`codiE`) ON DELETE CASCADE ON UPDATE CASCADE",
  );
  echo "✓ Clau forana afegida<br>";

  echo "<br><strong>Base de dades esportDaw inicialitzada correctament!</strong>";
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
