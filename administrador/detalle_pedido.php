<?php
include('db.php');

$id = $_GET['id'] ?? null;
if (!$id) {
  die('ID de orden no especificado.');
}

// Obtener info de la orden
$stmt = $pdo->prepare("SELECT * FROM ordenes WHERE id = ?");
$stmt->execute([$id]);
$orden = $stmt->fetch(PDO::FETCH_ASSOC);

// Obtener productos de la orden
$stmt = $pdo->prepare("
  SELECT d.*, p.nombre 
  FROM detalle_orden d
  JOIN productos p ON d.producto_id = p.id
  WHERE d.orden_id = ?
");
$stmt->execute([$id]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Detalle del Pedido</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
  <h2 class="text-primary mb-4">🧾 Detalle del Pedido #<?= $orden['id'] ?></h2>
  <p><strong>Cliente:</strong> <?= htmlspecialchars($orden['cliente_nombre']) ?></p>
  <p><strong>Teléfono:</strong> <?= $orden['cliente_telefono'] ?></p>
  <p><strong>Entrega:</strong> <?= $orden['metodo_entrega'] ?></p>
  <p><strong>Pago:</strong> <?= $orden['metodo_pago'] ?></p>
  <p><strong>Fecha:</strong> <?= $orden['fecha'] ?></p>
  <hr>
  <table class="table table-bordered text-center align-middle">
    <thead class="table-light">
      <tr>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Precio unidad</th>
        <th>Subtotal</th>
      </tr>
    </thead>
    <tbody>
      <?php $total = 0; foreach ($items as $item): 
        $subtotal = $item['cantidad'] * $item['precio'];
        $total += $subtotal;
      ?>
      <tr>
        <td><?= htmlspecialchars($item['nombre']) ?></td>
        <td><?= $item['cantidad'] ?></td>
        <td>$<?= number_format($item['precio'], 0, ',', '.') ?></td>
        <td>$<?= number_format($subtotal, 0, ',', '.') ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="3">Total</th>
        <th>$<?= number_format($total, 0, ',', '.') ?></th>
      </tr>
    </tfoot>
  </table>

  <div class="text-end">
    <a href="ver_pedidos.php" class="btn btn-secondary">🔙 Volver</a>
  </div>
</body>
</html>
