<?php
session_start();

// Verificar que el usuario esté logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: usuarios/login.php");
    exit();
}

include('administrador/db.php');
include('templates/cabecera.php');
?>
<script src="<?= $BASE ?>/js/mis-pedidos.js" defer></script>
<?php

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

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-header bg-success text-white">
                    <h2 class="mb-0">
                        <i class="ri-shopping-bag-line me-2"></i>
                        Mis Pedidos - Estado de Compras
                    </h2>
                </div>
                <div class="card-body">
                    <?php if (count($pedidos) > 0): ?>
                        <!-- Estadísticas rápidas -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="card bg-primary text-white text-center">
                                    <div class="card-body">
                                        <i class="ri-shopping-bag-line" style="font-size: 2rem;"></i>
                                        <h4 class="mt-2"><?= count($pedidos) ?></h4>
                                        <p class="mb-0">Total Pedidos</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-success text-white text-center">
                                    <div class="card-body">
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
                            <div class="col-md-3">
                                <div class="card bg-info text-white text-center">
                                    <div class="card-body">
                                        <i class="ri-calendar-line" style="font-size: 2rem;"></i>
                                        <h4 class="mt-2">
                                            <?= date('d/m/Y', strtotime($pedidos[0]['fechaPedido'])) ?>
                                        </h4>
                                        <p class="mb-0">Último Pedido</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-warning text-white text-center">
                                    <div class="card-body">
                                        <i class="ri-time-line" style="font-size: 2rem;"></i>
                                        <h4 class="mt-2">
                                            <?= count(array_filter($pedidos, function($p) { 
                                                return $p['estado'] === 'pendiente'; 
                                            })) ?>
                                        </h4>
                                        <p class="mb-0">Pendientes</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tabla de pedidos -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark">
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
                                                <strong class="text-primary">#<?= $pedido['idPedido'] ?></strong>
                                            </td>
                                            <td>
                                                <i class="ri-calendar-line me-1"></i>
                                                <?= date('d/m/Y H:i', strtotime($pedido['fechaPedido'])) ?>
                                            </td>
                                            <td>
                                                <span class="fw-bold text-success">
                                                    $<?= number_format($pedido['totalPagado'] + $pedido['costoEnvio'], 0, ',', '.') ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">
                                                    <i class="ri-bank-card-line me-1"></i>
                                                    <?= htmlspecialchars($pedido['metodoPago']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">
                                                    <i class="ri-truck-line me-1"></i>
                                                    <?= htmlspecialchars($pedido['tipoEnvio']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php
                                                $estadoClass = '';
                                                $estadoIcon = '';
                                                $estadoText = '';
                                                switch ($pedido['estado']) {
                                                    case 'pendiente':
                                                        $estadoClass = 'bg-warning';
                                                        $estadoIcon = 'ri-time-line';
                                                        $estadoText = 'Pendiente';
                                                        break;
                                                    case 'en_proceso':
                                                        $estadoClass = 'bg-info';
                                                        $estadoIcon = 'ri-settings-3-line';
                                                        $estadoText = 'En Proceso';
                                                        break;
                                                    case 'enviado':
                                                        $estadoClass = 'bg-primary';
                                                        $estadoIcon = 'ri-truck-line';
                                                        $estadoText = 'Enviado';
                                                        break;
                                                    case 'entregado':
                                                        $estadoClass = 'bg-success';
                                                        $estadoIcon = 'ri-check-line';
                                                        $estadoText = 'Entregado';
                                                        break;
                                                    case 'cancelado':
                                                        $estadoClass = 'bg-danger';
                                                        $estadoIcon = 'ri-close-line';
                                                        $estadoText = 'Cancelado';
                                                        break;
                                                    default:
                                                        $estadoClass = 'bg-secondary';
                                                        $estadoIcon = 'ri-question-line';
                                                        $estadoText = 'Desconocido';
                                                }
                                                ?>
                                                <span class="badge <?= $estadoClass ?>">
                                                    <i class="<?= $estadoIcon ?> me-1"></i>
                                                    <?= $estadoText ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="administrador/detalle_pedido.php?id=<?= $pedido['idPedido'] ?>" 
                                                       class="btn btn-sm btn-outline-primary" target="_blank" 
                                                       title="Ver detalles del pedido">
                                                        <i class="ri-eye-line"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-outline-info" 
                                                            onclick="mostrarSeguimiento(<?= $pedido['idPedido'] ?>, '<?= $pedido['estado'] ?>')"
                                                            title="Ver seguimiento">
                                                        <i class="ri-map-pin-line"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="ri-shopping-bag-line text-muted" style="font-size: 4rem;"></i>
                            <h4 class="text-muted mt-3">No tienes pedidos aún</h4>
                            <p class="text-muted">¡Haz tu primera compra y podrás hacer seguimiento de tus pedidos aquí!</p>
                            <a href="index.php" class="btn btn-primary btn-lg">
                                <i class="ri-store-line me-2"></i>Ir a la tienda
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para seguimiento -->
<div class="modal fade" id="seguimientoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="ri-map-pin-line me-2"></i>Seguimiento del Pedido
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="seguimientoContent">
                    <!-- El contenido se cargará dinámicamente -->
                </div>
            </div>
        </div>
    </div>
</div>



<?php include('templates/footer.php'); ?> 