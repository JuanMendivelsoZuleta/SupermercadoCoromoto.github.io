
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel de Administración</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/panel_admin.css" rel="stylesheet">
</head>
<body>

<header class="bg-primary text-white p-2 d-flex justify-content-between align-items-center">
    <img src="../img/logo.png" alt="Logo Supermercado" style="height:40px;">
    <a href="../usuarios/logout.php" class="btn btn-sm btn-outline-light">Cerrar sesión</a>
</header>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <nav class="col-12 col-md-3 col-lg-2 bg-light sidebar py-3 mb-3 mb-md-0">
      <h4 class="text-primary">👑 Panel Admin</h4>
      <div class="d-grid gap-2">
        <button class="btn btn-outline-dark" onclick="loadContent('ver_pedidos.php')">📦 Ver Pedidos</button>
        <button class="btn btn-outline-dark" onclick="loadContent('listar_productos.php')">📋 Gestionar Productos</button>
        <button class="btn btn-outline-dark" onclick="loadContent('ver_usuarios.php')">👥 Ver Usuarios</button>
      </div>
    </nav>

    <!-- Main Content -->
    <main class="col-12 col-md-9 col-lg-10 px-4" id="main-content">
      <h2 class="text-center text-primary mb-4 mt-4 mt-md-0">Bienvenido al Panel de Administración</h2>
      <p class="text-muted text-center">Selecciona una opción del menú para comenzar.</p>
    </main>
  </div>
</div>

<?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'eliminado'): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Producto eliminado',
            text: 'El producto fue eliminado exitosamente.',
            confirmButtonText: 'OK'
            }).then(() => {
      window.location.href = 'admin.php';
        });
    </script>
<?php elseif (isset($_GET['mensaje']) && $_GET['mensaje'] == 'no_encontrado'): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'No encontrado',
            text: 'No se encontró el producto a eliminar.',
            confirmButtonText: 'OK'
        });
    </script>
<?php endif; ?>

<?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'editado'): ?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    Swal.fire({
      icon: 'success',
      title: '¡Producto editado!',
      text: 'El producto se ha editado correctamente.',
      confirmButtonText: 'OK'
      }).then(() => {
      window.location.href = 'admin.php';
    });
  </script>
<?php endif; ?>

<?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'agregado'): ?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    Swal.fire({
      icon: 'success',
      title: '¡Producto guardado!',
      text: 'El producto se ha guardado correctamente.',
      confirmButtonText: 'OK'
    }).then(() => {
      window.location.href = 'admin.php';
    });
  </script>
<?php endif; ?>


<script src="../admin.js"></script>
</body>
</html>