<?php
session_start();

// Verificar si hay un pedido completado
if (!isset($_SESSION['pedido_completado'])) {
  header("Location: ../index.php");
  exit();
}

$pedido = $_SESSION['pedido_completado'];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>¡Gracias por tu compra!</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet"/>
</head>
<body class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card shadow-lg border-0">
        <div class="card-body text-center p-5">
          <div class="mb-4">
            <i class="ri-check-circle-line text-success" style="font-size: 4rem;"></i>
          </div>
          
          <h1 class="text-success mb-4">¡Gracias por tu compra!</h1>
          <p class="lead mb-4">Tu pedido ha sido recibido y será procesado.</p>
          
          <!-- Información del pedido -->
          <div class="alert alert-success">
            <h5 class="alert-heading">
              <i class="ri-shopping-bag-line me-2"></i>Pedido #<?= $pedido['idPedido'] ?> Confirmado
            </h5>
            <p class="mb-0">Fecha: <?= date('d/m/Y H:i', strtotime($pedido['fechaPedido'])) ?></p>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                  <h6 class="mb-0"><i class="ri-user-line me-2"></i>Información del Cliente</h6>
                </div>
                <div class="card-body text-start">
                  <p><strong>Nombre:</strong> <?= htmlspecialchars($pedido['nombre']) ?></p>
                  <p><strong>Email:</strong> <?= htmlspecialchars($pedido['email']) ?></p>
                  <p><strong>Teléfono:</strong> <?= htmlspecialchars($pedido['telefono']) ?></p>
                </div>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="card mb-3">
                <div class="card-header bg-info text-white">
                  <h6 class="mb-0"><i class="ri-truck-line me-2"></i>Información de Entrega</h6>
                </div>
                <div class="card-body text-start">
                  <p><strong>Método:</strong> <?= htmlspecialchars($pedido['metodoEntrega']) ?></p>
                  <p><strong>Método de Pago:</strong> <?= htmlspecialchars($pedido['metodoPago']) ?></p>
                  <p><strong>Estado:</strong> <span class="badge bg-warning">Pendiente</span></p>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Resumen de la compra -->
          <div class="card mb-4">
            <div class="card-header bg-success text-white">
              <h6 class="mb-0"><i class="ri-calculator-line me-2"></i>Resumen de la Compra</h6>
            </div>
            <div class="card-body">
              <div class="row text-start">
                <div class="col-md-6">
                  <p><strong>Subtotal:</strong> $<?= number_format($pedido['totalCarrito'], 0, ',', '.') ?></p>
                  <p><strong>Costo de envío:</strong> $<?= number_format($pedido['costoEnvio'], 0, ',', '.') ?></p>
                </div>
                <div class="col-md-6">
                  <h5 class="text-success"><strong>Total Final:</strong> $<?= number_format($pedido['total'], 0, ',', '.') ?></h5>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Información importante -->
          <div class="alert alert-warning">
            <h6><i class="ri-information-line me-2"></i>Información Importante</h6>
            <ul class="text-start mb-0">
              <li>Recibirás una confirmación por email en breve.</li>
              <li>Si elegiste pago por transferencia, te enviaremos los datos bancarios.</li>
              <li>Para pagos en efectivo, realiza el pago al momento de la entrega.</li>
              <li>Si elegiste recoger en tienda, te notificaremos cuando esté listo.</li>
              <li>Puedes hacer seguimiento de tu pedido desde tu perfil de usuario.</li>
            </ul>
          </div>
          
          <!-- Estado del pedido -->
          <div class="alert alert-info">
            <h6><i class="ri-time-line me-2"></i>Seguimiento del Pedido</h6>
            <div class="row text-center">
              <div class="col-md-3">
                <div class="border rounded p-2 bg-success text-white">
                  <i class="ri-check-line"></i><br>
                  <small>Pedido Recibido</small>
                </div>
              </div>
              <div class="col-md-3">
                <div class="border rounded p-2 bg-light">
                  <i class="ri-time-line"></i><br>
                  <small>En Proceso</small>
                </div>
              </div>
              <div class="col-md-3">
                <div class="border rounded p-2 bg-light">
                  <i class="ri-truck-line"></i><br>
                  <small>En Camino</small>
                </div>
              </div>
              <div class="col-md-3">
                <div class="border rounded p-2 bg-light">
                  <i class="ri-home-line"></i><br>
                  <small>Entregado</small>
                </div>
              </div>
            </div>
          </div>
          
          <div class="mt-4">
            <a href="../index.php" class="btn btn-primary btn-lg me-3">
              <i class="ri-home-line me-2"></i>Volver a la tienda
            </a>
                        <a href="../mis_pedidos.php" class="btn btn-outline-secondary btn-lg me-3">
                <i class="ri-shopping-bag-line me-2"></i>Ver mis pedidos
            </a>
            <a href="../administrador/ver_pedidos.php" class="btn btn-info btn-lg">
              <i class="ri-list-check me-2"></i>Ver todos los pedidos
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <script>
    // Limpiar el carrito de localStorage
    localStorage.removeItem('carrito');
    
    // Actualizar el contador del carrito
    if (window.actualizarContadorCarrito) {
      window.actualizarContadorCarrito();
    }
    
    // Limpiar la información del pedido de la sesión después de mostrarla
    setTimeout(function() {
      fetch('limpiar_sesion_pedido.php', {method: 'POST'});
    }, 10000); // 10 segundos
  </script>
</body>
</html>
