<?php
session_start();
include('../administrador/db.php');

$carrito = $_SESSION['carrito'] ?? [];

if (empty($carrito)) {
  echo "<p>🛒 No hay productos en el carrito.</p>";
  exit;
}

$ids = implode(',', array_keys($carrito));
$stmt = $pdo->query("SELECT * FROM productos WHERE id IN ($ids)");
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = 0;

foreach ($productos as $p) {
  $cantidad = $carrito[$p['id']];
  $subtotal = $p['precio'] * $cantidad;
  $total += $subtotal;

  echo "<div class='item'>
          <strong>{$p['nombre']}</strong><br>
          Cantidad: $cantidad<br>
          Subtotal: $" . number_format($subtotal, 0, ',', '.') . "
        </div>";
}

echo "<hr><p><strong>Total: $" . number_format($total, 0, ',', '.') . "</strong></p>";
