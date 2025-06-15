<?php
include('../administrador/db.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $clave = password_hash($_POST['clave'], PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, clave) VALUES (?, ?, ?)");
    $stmt->execute([$nombre, $email, $clave]);

    $_SESSION['usuario'] = ['nombre' => $nombre, 'email' => $email];
    header("Location: usuario/perfil.php");
    exit();
}
?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Registro</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head><body class="container mt-5">
<h2 class="mb-4 text-primary text-center">Crear cuenta</h2>
<form method="POST" class="row g-3">
  <div class="col-12"><label>Nombre:</label><input type="text" name="nombre" class="form-control" required></div>
  <div class="col-12"><label>Email:</label><input type="email" name="email" class="form-control" required></div>
  <div class="col-12"><label>Contraseña:</label><input type="password" name="clave" class="form-control" required></div>
  <div class="col-12 text-end">
    <button type="submit" class="btn btn-success">Registrarse</button>
    <a href="login.php" class="btn btn-warning">Ya tengo cuenta</a>
  </div>
</form></body></html>
