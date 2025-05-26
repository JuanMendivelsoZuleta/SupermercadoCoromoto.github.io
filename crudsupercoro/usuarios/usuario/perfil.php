<?php
include('../includes/auth_check.php');
?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Perfil</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head><body class="container mt-5">
<h2 class="text-success text-center mb-4">Bienvenido, <?= $_SESSION['usuario']['nombre'] ?></h2>
<p class="text-center">Email: <?= $_SESSION['usuario']['email'] ?></p>
<div class="text-center mt-4">
  <a href="../logout.php" class="btn btn-outline-danger">Cerrar sesión</a>
</div>
</body></html>
