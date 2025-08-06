<?php
session_start();
if (!isset($_SESSION['usuario']) || !isset($_SESSION['usuario']['idUsuario'])) {
    header("Location: ../../login.php");
    exit();
}

require_once(__DIR__ . '/../../administrador/db.php');
$idUsuario = $_SESSION['usuario']['idUsuario'];

$stmt = $pdo->prepare("SELECT COUNT(*) FROM administrador WHERE idUsuario = ?");
$stmt->execute([$idUsuario]);
if ($stmt->fetchColumn() == 0) {
    header("Location: ../../login.php");
    exit();
}
?>
