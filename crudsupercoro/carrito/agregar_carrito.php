<?php
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Crear el carrito si no existe
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    // Incrementar cantidad si ya existe
    if (isset($_SESSION['carrito'][$id])) {
        $_SESSION['carrito'][$id]++;
    } else {
        $_SESSION['carrito'][$id] = 1;
    }
}

// Redirigir de vuelta a la página desde donde se llamó
header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
