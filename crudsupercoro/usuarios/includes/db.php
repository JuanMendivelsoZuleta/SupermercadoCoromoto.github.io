<?php
$host = "localhost";
$dbname = "carritosupermercado";
$user = "root";
$pass = "";
$port = "3309";

try {
    $pdo = new PDO("mysql:host=localhost;port=3309;dbname=carritosupermercado;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
