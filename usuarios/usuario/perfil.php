<?php
include('../includes/auth_check.php');
include('../../administrador/db.php');

$idUsuario = $_SESSION['usuario']['idUsuario'];

// Obtener pedidos del usuario
$stmt = $pdo->prepare("
  SELECT p.*, pa.metodoPago, pa.totalPagado, ie.tipo as tipoEnvio, ie.costo as costoEnvio
  FROM pedido p
  LEFT JOIN pago pa ON p.idPedido = pa.idPedido
  LEFT JOIN informacionenvio ie ON p.idPedido = ie.idPedido
  WHERE p.idUsuario = ?
  ORDER BY p.fechaPedido DESC
");
$stmt->execute([$idUsuario]);
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Mi Perfil - Supermercado Coromoto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet"/>
</head>
<body class="container mt-5">
  <div class="row">
    <!-- Información del usuario -->
    <div class="col-md-4">
      <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
          <h4 class="mb-0">
            <i class="ri-user-line me-2"></i>Mi Perfil
          </h4>
        </div>
        <div class="card-body">
          <div class="text-center mb-3">
            <i class="ri-user-3-line text-primary" style="font-size: 3rem;"></i>
          </div>
          <h5 class="text-center text-success mb-3"><?= htmlspecialchars($_SESSION['usuario']['nombre']) ?></h5>
          
          <div class="mb-3">
            <p><strong><i class="ri-mail-line me-2"></i>Email:</strong><br>
            <?= htmlspecialchars($_SESSION['usuario']['email']) ?></p>
          </div>
          
          <?php if (isset($_SESSION['usuario']['telefono'])): ?>
          <div class="mb-3">
            <p><strong><i class="ri-phone-line me-2"></i>Teléfono:</strong><br>
            <?= htmlspecialchars($_SESSION['usuario']['telefono']) ?></p>
          </div>
          <?php endif; ?>
          
          <div class="mb-3">
            <p><strong><i class="ri-user-settings-line me-2"></i>ID Usuario:</strong><br>
            <?= htmlspecialchars($_SESSION['usuario']['idUsuario']) ?></p>
          </div>
          
          <div class="d-grid gap-2">
            <a href="../../index.php" class="btn btn-outline-primary">
              <i class="ri-home-line me-2"></i>Ir a la tienda
            </a>
            <a href="../logout.php" class="btn btn-outline-danger">
              <i class="ri-logout-box-line me-2"></i>Cerrar sesión
            </a>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Pedidos del usuario -->
    <div class="col-md-8">
      <div class="card shadow-lg">
        <div class="card-header bg-success text-white">
          <h4 class="mb-0">
            <i class="ri-shopping-bag-line me-2"></i>Mis Pedidos
          </h4>
        </div>
        <div class="card-body">
          <?php if (count($pedidos) > 0): ?>
            <div class="table-responsive">
              <table class="table table-hover">
                <thead class="table-light">
                  <tr>
                    <th>Pedido #</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Método Pago</th>
                    <th>Envío</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($pedidos as $pedido): ?>
                    <tr>
                      <td>
                        <strong>#<?= $pedido['idPedido'] ?></strong>
                      </td>
                      <td>
                        <?= date('d/m/Y H:i', strtotime($pedido['fechaPedido'])) ?>
                      </td>
                      <td>
                        <span class="fw-bold text-success">
                          $<?= number_format($pedido['totalPagado'] + $pedido['costoEnvio'], 0, ',', '.') ?>
                        </span>
                      </td>
                      <td>
                        <span class="badge bg-info">
                          <?= htmlspecialchars($pedido['metodoPago']) ?>
                        </span>
                      </td>
                      <td>
                        <span class="badge bg-secondary">
                          <?= htmlspecialchars($pedido['tipoEnvio']) ?>
                        </span>
                      </td>
                      <td>
                        <?php
                        $estadoClass = '';
                        $estadoIcon = '';
                        switch ($pedido['estado']) {
                          case 'pendiente':
                            $estadoClass = 'bg-warning';
                            $estadoIcon = 'ri-time-line';
                            break;
                          case 'en_proceso':
                            $estadoClass = 'bg-info';
                            $estadoIcon = 'ri-settings-3-line';
                            break;
                          case 'enviado':
                            $estadoClass = 'bg-primary';
                            $estadoIcon = 'ri-truck-line';
                            break;
                          case 'entregado':
                            $estadoClass = 'bg-success';
                            $estadoIcon = 'ri-check-line';
                            break;
                          case 'cancelado':
                            $estadoClass = 'bg-danger';
                            $estadoIcon = 'ri-close-line';
                            break;
                          default:
                            $estadoClass = 'bg-secondary';
                            $estadoIcon = 'ri-question-line';
                        }
                        ?>
                        <span class="badge <?= $estadoClass ?>">
                          <i class="<?= $estadoIcon ?> me-1"></i>
                          <?= ucfirst(str_replace('_', ' ', $pedido['estado'])) ?>
                        </span>
                      </td>
                      <td>
                        <a href="../../administrador/detalle_pedido.php?id=<?= $pedido['idPedido'] ?>" 
                           class="btn btn-sm btn-outline-primary" target="_blank">
                          <i class="ri-eye-line"></i> Ver
                        </a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          <?php else: ?>
            <div class="text-center py-5">
              <i class="ri-shopping-bag-line text-muted" style="font-size: 3rem;"></i>
              <h5 class="text-muted mt-3">No tienes pedidos aún</h5>
              <p class="text-muted">¡Haz tu primera compra y verás tus pedidos aquí!</p>
              <a href="../../index.php" class="btn btn-primary">
                <i class="ri-store-line me-2"></i>Ir a la tienda
              </a>
            </div>
          <?php endif; ?>
        </div>
      </div>
      
      <!-- Estadísticas -->
      <?php if (count($pedidos) > 0): ?>
        <div class="row mt-4">
          <div class="col-md-4">
            <div class="card bg-primary text-white">
              <div class="card-body text-center">
                <i class="ri-shopping-bag-line" style="font-size: 2rem;"></i>
                <h4 class="mt-2"><?= count($pedidos) ?></h4>
                <p class="mb-0">Total Pedidos</p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card bg-success text-white">
              <div class="card-body text-center">
                <i class="ri-money-dollar-circle-line" style="font-size: 2rem;"></i>
                <h4 class="mt-2">
                  $<?= number_format(array_sum(array_map(function($p) { 
                    return $p['totalPagado'] + $p['costoEnvio']; 
                  }, $pedidos)), 0, ',', '.') ?>
                </h4>
                <p class="mb-0">Total Gastado</p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card bg-info text-white">
              <div class="card-body text-center">
                <i class="ri-calendar-line" style="font-size: 2rem;"></i>
                <h4 class="mt-2">
                  <?= date('d/m/Y', strtotime($pedidos[0]['fechaPedido'])) ?>
                </h4>
                <p class="mb-0">Último Pedido</p>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
