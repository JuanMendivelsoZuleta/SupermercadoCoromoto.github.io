
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel de Administración</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet"/>
  <link href="../css/panel_admin.css" rel="stylesheet">
  <style>
    /* Estilos críticos para eliminar espacios */
    html, body {
      margin: 0 !important;
      padding: 0 !important;
      height: 100% !important;
      overflow-x: hidden !important;
    }
    
    .container-fluid {
      padding: 0 !important;
      margin: 0 !important;
    }
    
    .row {
      margin: 0 !important;
    }
    
    .col-12, .col-md-3, .col-md-9, .col-lg-2, .col-lg-10 {
      padding: 0 !important;
    }
    
    header {
      margin: 0 !important;
      padding: 10px 20px !important;
    }
  </style>
</head>
<body>

<header class="bg-primary text-white p-2 d-flex justify-content-between align-items-center">
    <img src="../img/logo.png" alt="Logo Supermercado" style="height:40px;">
    <a href="../usuarios/logout.php" class="btn btn-sm btn-outline-light">Cerrar sesión</a>
</header>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <nav class="col-12 col-md-3 col-lg-2 sidebar">
      <h4 class="text-primary">👑 Panel Admin</h4>
      <div class="d-grid gap-2">
        <button class="btn btn-outline-dark" onclick="loadContent('ver_pedidos.php')">📦 Ver Pedidos</button>
        <button class="btn btn-outline-dark" onclick="loadContent('listar_productos.php')">📋 Gestionar Productos</button>
        <button class="btn btn-outline-dark" onclick="loadContent('ver_usuarios.php')">👥 Ver Usuarios</button>
      </div>
    </nav>

    <!-- Main Content -->
    <main class="col-12 col-md-9 col-lg-10" id="main-content">
      <div id="contenido">
        <h2 class="text-center text-primary mb-4">Bienvenido al Panel de Administración</h2>
        <p class="text-muted text-center">Selecciona una opción del menú para comenzar.</p>
      </div>
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

<?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'error'): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ocurrió un error al eliminar el producto.',
            confirmButtonText: 'OK'
        });
    </script>
<?php endif; ?>

<?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'id_invalido'): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'ID Inválido',
            text: 'El ID del producto no es válido.',
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


<script src="../js/navbar.js"></script>

<script>
// Función mejorada para cargar contenido con manejo de errores
function loadContent(url) {
    console.log('Cargando contenido desde:', url);
    
    // Mostrar indicador de carga
    document.getElementById('contenido').innerHTML = `
        <div class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <p class="mt-3">Cargando contenido...</p>
        </div>
    `;
    
    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.text();
        })
        .then(html => {
            document.getElementById('contenido').innerHTML = html;
            console.log('Contenido cargado exitosamente');
        })
        .catch(error => {
            console.error('Error al cargar contenido:', error);
            document.getElementById('contenido').innerHTML = `
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Error al cargar el contenido</h4>
                    <p>No se pudo cargar la página solicitada. Error: ${error.message}</p>
                    <hr>
                    <p class="mb-0">Por favor, intenta nuevamente o contacta al administrador.</p>
                </div>
            `;
        });
}

// Verificar que la función esté disponible globalmente
window.loadContent = loadContent;
</script>

</body>
</html>