<?php
declare(strict_types=1);

$dbHost = 'localhost';
$dbPort = 3306;
$dbName = 'moja_strona';
$dbUser = 'cms_reader';
$dbPass = 'UZUPELNIJ_HASLO';

$dsn = "mysql:host={$dbHost};port={$dbPort};dbname={$dbName};charset=utf8mb4";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

$pdo = new PDO($dsn,$dbUser, $dbPass,$options);