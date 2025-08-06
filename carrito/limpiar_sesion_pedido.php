<?php
session_start();

// Limpiar la información del pedido completado de la sesión
if (isset($_SESSION['pedido_completado'])) {
    unset($_SESSION['pedido_completado']);
}

// Responder con un JSON para confirmar que se limpió
header('Content-Type: application/json');
echo json_encode(['success' => true]);
?> 