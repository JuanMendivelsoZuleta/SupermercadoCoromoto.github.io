<?php
// Header global del sitio - Incluye configuración de sesión y base de datos
// Este archivo se incluye en todas las páginas para mantener consistencia

include(__DIR__ . '/../administrador/db.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Definir ruta base para enlaces absolutos
$BASE = '/SupermercadoCoromoto';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supermercado Coromoto</title>
    
    <!-- Enlaces a fuentes y estilos externos -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= $BASE ?>/css/styles.css">
    <link rel="stylesheet" href="<?= $BASE ?>/css/index.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    
    <!-- Scripts externos y funcionalidades -->
    <script src="https://kit.fontawesome.com/4ed7a0ea78.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= $BASE ?>/js/navbar.js" defer></script>
    <script src="<?= $BASE ?>/js/carrito.js" defer></script>
    
    <!-- Función para actualizar el contador de productos en el carrito -->
    <script>
        function actualizarContadorCarrito() {
            const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
            const contador = document.getElementById('carrito-contador');
            const totalItems = carrito.reduce((total, item) => total + item.cantidad, 0);
            
            if (totalItems > 0) {
                contador.textContent = totalItems;
                contador.style.display = 'inline';
            } else {
                contador.style.display = 'none';
            }
        }
        
        // Actualizar contador cuando se carga la página
        document.addEventListener('DOMContentLoaded', function() {
            actualizarContadorCarrito();
        });
    </script>
</head>
<body>
    <!-- Header principal con logo, buscador y controles de usuario -->
    <header>
        <div class="d-flex justify-content-between align-items-center w-100">
            <!-- Logo y nombre del supermercado -->
            <div class="logo">
                <a href="<?= $BASE ?>/index.php">
                    <img src="<?= $BASE ?>/img/logo.png" alt="logo" width="100" height="60">
                </a>
                <figcaption>Supermercado <br> Coromoto</figcaption>
            </div>

            <!-- Barra de búsqueda de productos -->
            <div class="containerr position-relative">
                <form action="<?= $BASE ?>/PHP/buscar.php" method="GET" autocomplete="off">
                <input type="text" name="q" id="buscador" placeholder="¿Qué estás buscando?..." required>
                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
                <div id="sugerencias" class="list-group position-absolute w-100" style="z-index: 9999;"></div>
            </div>

            <!-- Controles de usuario y navegación -->
            <div class="botonuser">
                <?php if (isset($_SESSION['usuario'])): ?>
                    <!-- Usuario autenticado - Mostrar opciones de usuario -->
                    <span class="user-welcome me-3">
                        <i class="ri-user-line me-1"></i>
                        Hola, <?= htmlspecialchars($_SESSION['usuario']['nombre'] ?? 'Usuario') ?>
                    </span>
                    <a href="<?= $BASE ?>/carrito.php" class="btn btn-outline-primary btn-sm me-2 position-relative">
                        <i class="fa-solid fa-cart-shopping me-1"></i>Carrito
                        <span id="carrito-contador" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display: none;">
                            0
                        </span>
                    </a>
                    <a href="<?= $BASE ?>/mis_pedidos.php" class="btn btn-outline-success btn-sm me-2">
                        <i class="ri-shopping-bag-line me-1"></i>Mis Pedidos
                    </a>
                    <?php if (isset($_SESSION['usuario']['esAdmin']) && $_SESSION['usuario']['esAdmin']): ?>
                        <a href="<?= $BASE ?>/administrador/admin.php" class="btn btn-warning btn-sm me-2">
                            <i class="ri-admin-line me-1"></i>Admin
                        </a>
                    <?php endif; ?>
                    <a href="<?= $BASE ?>/usuarios/logout.php" class="btn btn-danger btn-sm">
                        <i class="ri-logout-box-line me-1"></i>Cerrar
                    </a>
                <?php else: ?>
                    <!-- Usuario no autenticado - Mostrar opciones de registro/login -->
                    <a href="<?= $BASE ?>/usuarios/registro.php" class="btn btn-warning btn-sm me-2">
                        <i class="ri-user-add-line me-1"></i>Registrarse
                    </a>
                    <a href="<?= $BASE ?>/usuarios/login.php" class="btn btn-primary btn-sm">
                        <i class="ri-login-box-line me-1"></i>Iniciar Sesión
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Menú de navegación principal -->
    <nav>
        <ul class="menu-horizontal">
            <li><a href="<?= $BASE ?>/index.php">Inicio</a></li>
            <li>
                <a href="<?= $BASE ?>/categorias.php">Categorías</a>
                <ul class="menu-vertical">
                    <li><a href="<?= $BASE ?>/categorias.php">Ver todas las categorías</a></li>
                    <li><a href="<?= $BASE ?>/categoria_detalle.php?id=1">Verduras y Hortalizas</a></li>
                    <li><a href="<?= $BASE ?>/categoria_detalle.php?id=2">Frutas</a></li>
                    <li><a href="<?= $BASE ?>/categoria_detalle.php?id=3">Carnes y Pescados</a></li>
                    <li><a href="<?= $BASE ?>/categoria_detalle.php?id=4">Lácteos</a></li>
                    <li><a href="<?= $BASE ?>/categoria_detalle.php?id=5">Panadería</a></li>
                    <li><a href="<?= $BASE ?>/categoria_detalle.php?id=6">Licores y Bebidas</a></li>
                    <li><a href="<?= $BASE ?>/categoria_detalle.php?id=7">Bebidas</a></li>
                    <li><a href="<?= $BASE ?>/categoria_detalle.php?id=8">Productos de Limpieza</a></li>
                    <li><a href="<?= $BASE ?>/categoria_detalle.php?id=9">Higiene Personal</a></li>
                    <li><a href="<?= $BASE ?>/categoria_detalle.php?id=10">Snacks y Golosinas</a></li>
                    <li><a href="<?= $BASE ?>/categoria_detalle.php?id=11">Conservas</a></li>
                    <li><a href="<?= $BASE ?>/categoria_detalle.php?id=12">Condimentos</a></li>
                    <li><a href="<?= $BASE ?>/categoria_detalle.php?id=13">Granos y Cereales</a></li>
                    <li><a href="<?= $BASE ?>/categoria_detalle.php?id=14">Congelados</a></li>
                    <li><a href="<?= $BASE ?>/categoria_detalle.php?id=15">Dulces y Mermeladas</a></li>
                </ul>
            </li>
            <?php if (isset($_SESSION['usuario'])): ?>
            <li><a href="<?= $BASE ?>/mis_pedidos.php">Mis Pedidos</a></li>
            <?php endif; ?>
            <li><a href="<?= $BASE ?>/contacto/contacto.html" target="_blank">Contáctanos</a></li>
        </ul>
    </nav>