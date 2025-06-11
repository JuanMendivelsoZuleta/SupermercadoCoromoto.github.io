<?php
include('db.php');
$stmt = $pdo->query("SELECT * FROM ordenes ORDER BY fecha DESC");
$ordenes = $stmt->fetchAll(PDO::FETCH_ASSOC);
include(__DIR__ . '/../usuarios/includes/admin_check.php');
?>




  <meta charset="UTF-8">
  <title>Pedidos Realizados</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


  <h2 class="text-center text-primary mb-4">📦 Pedidos Realizados</h2>
  <table class="table table-bordered text-center align-middle">
    <thead class="table-light">
      <tr>
        <th>ID</th>
        <th>Cliente</th>
        <th>Teléfono</th>
        <th>Entrega</th>
        <th>Pago</th>
        <th>Total</th>
        <th>Fecha</th>
        <th>Acción</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($ordenes as $orden): ?>
        <tr>
          <td><?= $orden['id'] ?></td>
          <td><?= htmlspecialchars($orden['cliente_nombre']) ?></td>
          <td><?= $orden['cliente_telefono'] ?></td>
          <td><?= $orden['metodo_entrega'] ?></td>
          <td><?= $orden['metodo_pago'] ?></td>
          <td>$<?= number_format($orden['total'], 0, ',', '.') ?></td>
          <td><?= $orden['fecha'] ?></td>
          <td><a onclick="loadContent('detalle_pedido.php?id=<?= $orden['id'] ?>')" class="btn btn-sm btn-info">👁 Ver</a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>