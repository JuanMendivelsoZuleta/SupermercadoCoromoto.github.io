<?php
session_start();

if (empty($_SESSION['carrito'])) {
  header("Location: carrito.php");
  exit();
}

// Verificar que el usuario esté logueado
if (!isset($_SESSION['usuario'])) {
  header("Location: ../usuarios/login.php");
  exit();
}

// Obtener mensaje de error si existe
$error = $_GET['error'] ?? '';
$mensajeError = '';
switch ($error) {
  case 'datos_incompletos':
    $mensajeError = 'Por favor, selecciona el método de pago y envío.';
    break;
  case 'error_procesamiento':
    $mensajeError = 'Hubo un error al procesar tu pedido. Por favor, intenta nuevamente.';
    break;
}

// Obtener datos del usuario de la sesión
$usuario = $_SESSION['usuario'];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Finalizar Compra</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet"/>
</head>
<body class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white">
          <h2 class="text-center mb-0">
            <i class="ri-shopping-cart-line me-2"></i>Finalizar Compra
          </h2>
        </div>
        <div class="card-body p-4">
          <?php if ($mensajeError): ?>
            <div class="alert alert-danger">
              <i class="ri-error-warning-line me-2"></i><?= htmlspecialchars($mensajeError) ?>
            </div>
          <?php endif; ?>
          
          <!-- Información del cliente -->
          <div class="alert alert-info">
            <h6><i class="ri-user-line me-2"></i>Información del cliente:</h6>
            <div class="row">
              <div class="col-md-6">
                <p><strong>Nombre:</strong> <?= htmlspecialchars($usuario['nombre'] ?? 'No disponible') ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($usuario['email'] ?? 'No disponible') ?></p>
              </div>
              <div class="col-md-6">
                <p><strong>Teléfono:</strong> <?= htmlspecialchars($usuario['telefono'] ?? 'No disponible') ?></p>
                <p><strong>Usuario ID:</strong> <?= htmlspecialchars($usuario['idUsuario'] ?? 'No disponible') ?></p>
              </div>
            </div>
          </div>
          
          <form action="procesar_compra.php" method="POST" class="row g-3">
            <!-- Campos ocultos con datos del usuario -->
            <input type="hidden" name="nombre" value="<?= htmlspecialchars($usuario['nombre'] ?? '') ?>">
            <input type="hidden" name="email" value="<?= htmlspecialchars($usuario['email'] ?? '') ?>">
            <input type="hidden" name="telefono" value="<?= htmlspecialchars($usuario['telefono'] ?? '') ?>">
            
            <div class="col-md-6">
              <label class="form-label">
                <i class="ri-truck-line me-1"></i>Método de entrega:
              </label>
              <select name="entrega" class="form-select" required>
                <option value="">Seleccionar</option>
                <option value="Domicilio" <?= ($_POST['entrega'] ?? '') === 'Domicilio' ? 'selected' : '' ?>>
                  Domicilio (+$5,000)
                </option>
                <option value="Recoger en tienda" <?= ($_POST['entrega'] ?? '') === 'Recoger en tienda' ? 'selected' : '' ?>>
                  Recoger en tienda (Gratis)
                </option>
              </select>
            </div>
            
            <div class="col-md-6">
              <label class="form-label">
                <i class="ri-bank-card-line me-1"></i>Método de pago:
              </label>
              <select name="pago" class="form-select" required>
                <option value="">Seleccionar</option>
                <option value="Efectivo" <?= ($_POST['pago'] ?? '') === 'Efectivo' ? 'selected' : '' ?>>
                  Efectivo
                </option>
                <option value="Transferencia" <?= ($_POST['pago'] ?? '') === 'Transferencia' ? 'selected' : '' ?>>
                  Transferencia
                </option>
                <option value="Nequi / Daviplata" <?= ($_POST['pago'] ?? '') === 'Nequi / Daviplata' ? 'selected' : '' ?>>
                  Nequi / Daviplata
                </option>
              </select>
            </div>
            
            <div class="col-12">
              <div class="alert alert-warning">
                <h6><i class="ri-information-line me-2"></i>Información importante:</h6>
                <ul class="mb-0">
                  <li>Para pagos por transferencia, te enviaremos los datos bancarios por email.</li>
                  <li>Para pagos en efectivo, realiza el pago al momento de la entrega.</li>
                  <li>El envío a domicilio tiene un costo adicional de $5,000.</li>
                  <li>Si necesitas cambiar tus datos de contacto, actualízalos en tu perfil.</li>
                </ul>
              </div>
            </div>
            
            <div class="col-12 text-end">
              <a href="carrito.php" class="btn btn-secondary me-2">
                <i class="ri-arrow-left-line me-1"></i>Volver
              </a>
              <button type="submit" class="btn btn-success">
                <i class="ri-check-line me-1"></i>Confirmar pedido
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
