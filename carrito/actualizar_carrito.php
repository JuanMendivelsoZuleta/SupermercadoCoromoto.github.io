<?php
session_start();

// Manejar tanto POST como GET
$id = $_POST['id'] ?? $_GET['id'] ?? null;
$cantidad = $_POST['cantidad'] ?? $_GET['cantidad'] ?? null;

if ($id && $cantidad !== null) {
    $id = intval($id);
    $cantidad = max(1, intval($cantidad)); // Mínimo 1
    
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }
    
    if ($cantidad > 0) {
        $_SESSION['carrito'][$id] = $cantidad;
    } else {
        // Si la cantidad es 0 o menor, eliminar el producto
        unset($_SESSION['carrito'][$id]);
    }
}

header("Location: carrito.php");
exit();
?>
