<?php
include('db.php');

$id = $_GET['id'] ?? null;
if (!$id) {
  die('ID de pedido no especificado.');
}

$stmt = $pdo->prepare("SELECT * FROM pedido WHERE idPedido = ?");
$stmt->execute([$id]);
$pedido = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("
  SELECT d.*, p.nombre 
  FROM detallepedido d
  JOIN producto p ON d.idProducto = p.idProducto
  WHERE d.idPedido = ?");
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
  <h2 class="text-center text-primary">Detalle del Pedido #<?= $id ?></h2>
  <p><strong>Estado:</strong> <?= $pedido['estado'] ?></p>
  <table class="table table-bordered">
    <thead><tr><th>Producto</th><th>Cantidad</th><th>Costo Unitario</th><th>Total</th></tr></thead>
    <tbody>
      <?php foreach ($items as $item): ?>
        <tr>
          <td><?= htmlspecialchars($item['nombre']) ?></td>
          <td><?= $item['cantidad'] ?></td>
          <td>$<?= $item['costoUnitario'] ?></td>
          <td>$<?= $item['total'] ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>
</html>
