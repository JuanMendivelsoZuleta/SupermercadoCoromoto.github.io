<?php 
include(__DIR__ . '/../usuarios/includes/admin_check.php'); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Panel Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
  <h2 class="text-center text-primary mb-4">👑 Panel de Administración</h2>
  <div class="d-grid gap-3 col-md-6 mx-auto">
    <a href="ver_pedidos.php" class="btn btn-outline-dark">📦 Ver Pedidos</a>
    <a href="listar_productos.php" class="btn btn-outline-dark">📋 Gestionar Productos</a>
    <a href="ver_usuarios.php" class="btn btn-outline-dark">👥 Ver Usuarios</a>
  </div>
</body>
</html>
