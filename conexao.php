<?php

$host = "localhost";
$db   = "restaurante";
$user = "root";
$pass = "";

$pdo = new PDO(
"mysql:host=$host;dbname=$db;charset=utf8mb4",
$user,
$pass
);

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec("SET NAMES utf8mb4");

?>