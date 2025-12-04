<?php
$config = require __DIR__ . '/config.php';
$dsn = "mysql:host={$config['host']};charset={$config['charset']}";
try {
    $pdo = new PDO($dsn, $config['user'], $config['pass'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$config['dbname']}` CHARACTER SET {$config['charset']}");
    $pdo->exec("USE `{$config['dbname']}`;
    CREATE TABLE IF NOT EXISTS `wishlist` (
      `id` INT AUTO_INCREMENT PRIMARY KEY,
      `item` VARCHAR(255) NOT NULL,
      `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    echo "Database and table created.";
} catch (PDOException $e) {
    echo "DB error: " . $e->getMessage();
}