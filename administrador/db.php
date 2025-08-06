<?php
// Configuración de conexión a la base de datos
// Archivo centralizado para la conexión PDO a MySQL

// Parámetros de conexión a la base de datos
$host = "localhost";
$dbname = "tiendaonline";
$user = "root";
$pass = ""; 

// Establecer conexión PDO con manejo de errores
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>