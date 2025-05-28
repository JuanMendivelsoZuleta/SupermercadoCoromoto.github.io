<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de Administración</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/panel_admin.css" rel="stylesheet">
</head>
<body>

<header>
    <img src="../img/logo.png" alt="Logo Supermercado">
    <a href="../usuarios/logout.php" class="btn btn-sm btn-outline-light">Cerrar sesión</a>
</header>

  <div class="main-layout">
    <div class="sidebar">
      <h4 class="text-primary">👑 Panel Admin</h4>
      <div class="d-grid gap-2">
        <button class="btn btn-outline-dark" onclick="loadContent('ver_pedidos.php')">📦 Ver Pedidos</button>
        <button class="btn btn-outline-dark" onclick="loadContent('listar_productos.php')">📋 Gestionar Productos</button>
        <button class="btn btn-outline-dark" onclick="loadContent('ver_usuarios.php')">👥 Ver Usuarios</button>
      </div>
    </div>

  <div class="content" id="main-content">
    <h2 class="text-center text-primary mb-4">Bienvenido al Panel de Administración</h2>
    <p class="text-muted text-center">Selecciona una opción del menú para comenzar.</p>
  </div>

  <script src="../admin.js"></script>
</body>
</html>
