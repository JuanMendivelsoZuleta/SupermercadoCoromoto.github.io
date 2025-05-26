<?php
include(__DIR__ . '/../administrador/db.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ruta base absoluta
$BASE = '/crudsupercoro';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Supermercado Coromoto</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tu CSS personalizado -->
    <link rel="stylesheet" href="<?= $BASE ?>/css/styles.css">

    <!-- Iconos -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet"/>
    <script src="https://kit.fontawesome.com/4ed7a0ea78.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <div class="logo">
            <a href="<?= $BASE ?>/index.php">
                <img src="<?= $BASE ?>/img/logo.png" alt="logo" width="140" height="100">
            </a>
            <figcaption>Supermercado <br> Coromoto</figcaption>
        </div>

        <div class="containerr position-relative">
            <form action="<?= $BASE ?>/PHP/buscar.php" method="GET" autocomplete="off">
            <input type="text" name="q" id="buscador" placeholder="¿Qué estás buscando?..." required>
            <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
            <div id="sugerencias" class="list-group position-absolute w-100" style="z-index: 9999;"></div>
        </div>


        <div class="botonuser">
            <a href="<?= $BASE ?>/usuarios/registro.php"><button><i class="fa-solid fa-user"></i></button></a>
            <a href="<?= $BASE ?>/carrito/carrito.php"><button><i class="fa-solid fa-cart-shopping"></i></button></a>
            <a href="<?= $BASE ?>/usuarios/login.php"><button><i class="fa-solid fa-right-to-bracket"></i></button></a>
        </div>
    </header>

    <nav>
        <ul class="menu-horizontal">
            <li><a href="<?= $BASE ?>/index.php">Inicio</a></li>
            <li>
                <a href="#">Categorías</a>
                <ul class="menu-vertical">
                    <li><a href="<?= $BASE ?>/PHP/granos.php">Granos</a></li>
                    <li><a href="<?= $BASE ?>/PHP/verduras.php">Verduras</a></li>
                    <li><a href="<?= $BASE ?>/PHP/congelados.php">Congelados</a></li>
                    <li><a href="<?= $BASE ?>/PHP/licores.php">Licores</a></li>
                </ul>
            </li>
            <li><a href="<?= $BASE ?>/PHP/contacto.html" target="_blank">Contáctanos</a></li>
        </ul>
    </nav>
