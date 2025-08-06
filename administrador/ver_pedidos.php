<?php
include('db.php');
include(__DIR__ . '/../usuarios/includes/admin_check.php');

$stmt = $pdo->query("
  SELECT p.*, c.nombre AS cliente
  FROM pedido p
  JOIN cliente c ON p.idUsuario = c.idUsuario
  ORDER BY p.fechaPedido DESC");
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header bg-primary text-white">
          <h2 class="mb-0">
            <i class="ri-shopping-bag-line me-2"></i>
            Pedidos Realizados
          </h2>
        </div>
        <div class="card-body">
          <?php if (count($pedidos) > 0): ?>
            <div class="table-responsive">
              <table class="table table-striped table-hover">
                <thead class="table-dark">
                  <tr>
                    <th>ID Pedido</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($pedidos as $p): ?>
                    <tr>
                      <td><strong>#<?= $p['idPedido'] ?></strong></td>
                      <td><?= htmlspecialchars($p['cliente']) ?></td>
                      <td><?= date('d/m/Y H:i', strtotime($p['fechaPedido'])) ?></td>
                      <td>
                        <span class="badge bg-<?= $p['estado'] === 'pendiente' ? 'warning' : ($p['estado'] === 'entregado' ? 'success' : 'info') ?>">
                          <?= ucfirst($p['estado']) ?>
                        </span>
                      </td>
                      <td>
                        <a class="btn btn-sm btn-outline-primary" href="detalle_pedido.php?id=<?= $p['idPedido'] ?>" target="_blank">
                          <i class="ri-eye-line me-1"></i>Ver detalle
                        </a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          <?php else: ?>
            <div class="text-center py-5">
              <i class="ri-shopping-bag-line text-muted" style="font-size: 4rem;"></i>
              <h4 class="text-muted mt-3">No hay pedidos registrados</h4>
              <p class="text-muted">Aún no se han realizado pedidos en el sistema.</p>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
