<?php
include('../administrador/db.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_SESSION['carrito'])) {
  $nombre = $_POST['nombre'];
  $email = $_POST['email'];
  $telefono = $_POST['telefono'];
  $entrega = $_POST['entrega'];
  $pago = $_POST['pago'];

  $carrito = $_SESSION['carrito'];
  $ids = implode(',', array_keys($carrito));
  $stmt = $pdo->query("SELECT * FROM productos WHERE id IN ($ids)");
  $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $total = 0;
  foreach ($productos as $producto) {
    $cantidad = $carrito[$producto['id']];
    $total += $producto['precio'] * $cantidad;
  }

  $stmt = $pdo->prepare("INSERT INTO ordenes (cliente_nombre, cliente_email, cliente_telefono, metodo_entrega, metodo_pago, total) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->execute([$nombre, $email, $telefono, $entrega, $pago, $total]);
  $orden_id = $pdo->lastInsertId();

  $stmt_detalle = $pdo->prepare("INSERT INTO detalle_orden (orden_id, producto_id, cantidad, precio) VALUES (?, ?, ?, ?)");
  foreach ($productos as $producto) {
    $cantidad = $carrito[$producto['id']];
    $stmt_detalle->execute([$orden_id, $producto['id'], $cantidad, $producto['precio']]);

    // Descontar del stock
$actualizar_stock = $pdo->prepare("UPDATE productos SET stock = stock - ? WHERE id = ?");
$actualizar_stock->execute([$cantidad, $producto['id']]);

  }

  unset($_SESSION['carrito']);
  header("Location: gracias.php");
  exit();
} else {
  header("Location: ../carrito.php");
  exit();
}
?>