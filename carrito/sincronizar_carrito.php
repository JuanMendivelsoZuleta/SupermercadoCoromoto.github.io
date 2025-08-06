<?php
session_start();
header('Content-Type: application/json');

// Obtener datos del carrito desde localStorage (enviados por JavaScript)
$input = file_get_contents('php://input');
$carritoData = json_decode($input, true);

if ($carritoData && is_array($carritoData)) {
    // Convertir el formato del carrito de localStorage al formato de sesión PHP
    $_SESSION['carrito'] = [];
    
    foreach ($carritoData as $item) {
        if (isset($item['id']) && isset($item['cantidad'])) {
            $_SESSION['carrito'][$item['id']] = intval($item['cantidad']);
        }
    }
    
    echo json_encode([
        'status' => 'success',
        'message' => 'Carrito sincronizado correctamente',
        'carrito' => $_SESSION['carrito']
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Datos del carrito no válidos'
    ]);
}
?> 