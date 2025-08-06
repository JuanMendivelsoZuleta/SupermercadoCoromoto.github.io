<?php
// Procesamiento de la compra - Maneja la creación de pedidos en la base de datos
// Incluye validación, transacciones y gestión de datos del carrito

session_start();
require_once("../administrador/db.php");

// Verificar que el usuario esté autenticado y tenga productos en el carrito
if (!isset($_SESSION['usuario']) || empty($_SESSION['carrito'])) {
  header("Location: carrito.php");
  exit();
}

// Verificar que se enviaron los datos del formulario por POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header("Location: finalizar_compra.php");
  exit();
}

$idUsuario = $_SESSION['usuario']['idUsuario'];
$carrito = $_SESSION['carrito'];

// Obtener métodos de pago y entrega del formulario
$metodoEntrega = $_POST['entrega'] ?? '';
$metodoPago = $_POST['pago'] ?? '';

// Obtener información del usuario desde la sesión
$nombre = $_SESSION['usuario']['nombre'] ?? '';
$email = $_SESSION['usuario']['email'] ?? '';
$telefono = $_SESSION['usuario']['telefono'] ?? '';

// Validar que se proporcionaron los datos requeridos
if (empty($metodoEntrega) || empty($metodoPago)) {
  header("Location: finalizar_compra.php?error=datos_incompletos");
  exit();
}

try {
  // Iniciar transacción de base de datos para garantizar consistencia
  $pdo->beginTransaction();
  
  // Calcular el total del carrito consultando precios de productos
  $totalCarrito = 0;
  foreach ($carrito as $idProducto => $cantidad) {
    $producto = $pdo->prepare("SELECT precio FROM producto WHERE idProducto = ?");
    $producto->execute([$idProducto]);
    $row = $producto->fetch(PDO::FETCH_ASSOC);
    if ($row) {
      $totalCarrito += $row['precio'] * $cantidad;
    }
  }
  
  // Crear el registro principal del pedido
  $stmt = $pdo->prepare("INSERT INTO pedido (idUsuario, fechaPedido, estado) VALUES (?, NOW(), 'pendiente')");
  $stmt->execute([$idUsuario]);
  $idPedido = $pdo->lastInsertId();
  
  // Registrar cada producto del carrito en el detalle del pedido
  foreach ($carrito as $idProducto => $cantidad) {
    $producto = $pdo->prepare("SELECT precio FROM producto WHERE idProducto = ?");
    $producto->execute([$idProducto]);
    $row = $producto->fetch(PDO::FETCH_ASSOC);
    if ($row) {
      $precio = $row['precio'];
      $total = $precio * $cantidad;
  
      $stmt = $pdo->prepare("INSERT INTO detallepedido (idPedido, idProducto, cantidad, costoUnitario, total)
                             VALUES (?, ?, ?, ?, ?)");
      $stmt->execute([$idPedido, $idProducto, $cantidad, $precio, $total]);
    }
  }
  
  // Registrar información del método de pago
  $stmt = $pdo->prepare("INSERT INTO pago (idPedido, metodoPago, totalPagado, estado) VALUES (?, ?, ?, 'pendiente')");
  $stmt->execute([$idPedido, $metodoPago, $totalCarrito]);
  
  // Registrar información del método de entrega y calcular costo
  $costoEnvio = ($metodoEntrega === 'Domicilio') ? 5000 : 0; // Costo de envío a domicilio
  $stmt = $pdo->prepare("INSERT INTO informacionenvio (idPedido, tipo, costo) VALUES (?, ?, ?)");
  $stmt->execute([$idPedido, $metodoEntrega, $costoEnvio]);
  
  // Calcular el total final incluyendo envío
  $totalFinal = $totalCarrito + $costoEnvio;
  
  // Confirmar todas las operaciones de base de datos
  $pdo->commit();
  
  // Limpiar el carrito de la sesión del usuario
  unset($_SESSION['carrito']);
  
  // Guardar información del pedido para mostrar en la página de confirmación
  $_SESSION['pedido_completado'] = [
    'idPedido' => $idPedido,
    'total' => $totalFinal,
    'metodoPago' => $metodoPago,
    'metodoEntrega' => $metodoEntrega,
    'nombre' => $nombre,
    'email' => $email,
    'telefono' => $telefono,
    'fechaPedido' => date('Y-m-d H:i:s'),
    'totalCarrito' => $totalCarrito,
    'costoEnvio' => $costoEnvio
  ];
  
  // Redirigir a la página de confirmación exitosa
  header("Location: gracias.php");
  exit();
  
} catch (Exception $e) {
  // Revertir todas las operaciones en caso de error
  $pdo->rollBack();
  error_log("Error en procesar_compra.php: " . $e->getMessage());
  header("Location: finalizar_compra.php?error=error_procesamiento");
  exit();
}
?>
