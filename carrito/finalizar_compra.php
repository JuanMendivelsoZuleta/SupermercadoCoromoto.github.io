<?php
session_start();

if (empty($_SESSION['carrito'])) {
  header("Location: carrito.php");
  exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Finalizar Compra</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
  <h2 class="text-primary text-center mb-4">Finalizar Compra</h2>
  <form action="procesar_compra.php" method="POST"class="row g-3">
    <div class="col-md-6"><label class="form-label">Nombre completo:</label><input type="text" name="nombre" class="form-control" required></div>
    <div class="col-md-6"><label class="form-label">Correo electrónico:</label><input type="email" name="email" class="form-control" required></div>
    <div class="col-md-6"><label class="form-label">Teléfono:</label><input type="text" name="telefono" class="form-control" required></div>
    <div class="col-md-6"><label class="form-label">Método de entrega:</label>
      <select name="entrega" class="form-select" required>
        <option value="">Seleccionar</option>
        <option value="Domicilio">Domicilio</option>
        <option value="Recoger en tienda">Recoger en tienda</option>
      </select>
    </div>
    <div class="col-md-6"><label class="form-label">Método de pago:</label>
      <select name="pago" class="form-select" required>
        <option value="">Seleccionar</option>
        <option value="Efectivo">Efectivo</option>
        <option value="Transferencia">Transferencia</option>
        <option value="Nequi / Daviplata">Nequi / Daviplata</option>
      </select>
    </div>
    <div class="col-12 text-end">
      <a href="carrito.php" class="btn btn-secondary">Volver</a>
      <button type="submit" class="btn btn-success">Confirmar pedido</button>
    </div>
  </form>
</body>
</html>
