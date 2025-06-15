<?php
include('../administrador/db.php');
session_start();

$carrito = $_SESSION['carrito'] ?? [];
$productos_en_carrito = [];
$total = 0;

if (!empty($carrito)) {
    $ids = implode(',', array_keys($carrito));
    $stmt = $pdo->query("SELECT * FROM productos WHERE id IN ($ids)");
    $productos_en_carrito = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Mi Carrito</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
  <h1 class="text-center text-success mb-4">🛒 Mi Carrito de Compras</h1>
  <?php if (empty($carrito)): ?>
    <div class="alert alert-warning text-center">Tu carrito está vacío.</div>
    <div class="text-center">
      <a href="../index.php" class="btn btn-primary">Ir a la tienda</a>
    </div>
  <?php else: ?>
    <table class="table table-bordered text-center align-middle">
      <thead class="table-light">
        <tr><th>Imagen</th><th>Producto</th><th>Precio</th><th>Cantidad</th><th>Subtotal</th><th>Eliminar</th></tr>
      </thead>
      <tbody>
        <?php foreach ($productos_en_carrito as $producto): 
          $cantidad = $carrito[$producto['id']];
          $subtotal = $producto['precio'] * $cantidad;
          $total += $subtotal;
        ?>
        <tr>
          <td><img src="../administrador/<?= $producto['imagen'] ?>" width="80" style="object-fit: cover;"></td>
          <td><?= htmlspecialchars($producto['nombre']) ?></td>
          <td>$<?= number_format($producto['precio'], 0, ',', '.') ?></td>
          <td>
  <form action="actualizar_carrito.php" method="POST" class="d-flex justify-content-center align-items-center">
    <input type="hidden" name="id" value="<?= $producto['id'] ?>">
    <input type="number" name="cantidad" value="<?= $cantidad ?>" min="1" class="form-control form-control-sm w-50 me-1">
    <button type="submit" class="btn btn-sm btn-primary">↺</button>
  </form>
</td>

          <td>$<?= number_format($subtotal, 0, ',', '.') ?></td>
          <td><a href="quitar_producto.php?id=<?= $producto['id'] ?>" class="btn btn-sm btn-danger">🗑️</a></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <div class="text-end">
      <h4>Total: $<?= number_format($total, 0, ',', '.') ?></h4>
      <a href="vaciar_carrito.php" class="btn btn-outline-danger me-2">Vaciar carrito</a>
      <a href="finalizar_compra.php" class="btn btn-success">Finalizar compra</a>
    </div>
  <?php endif; ?>
</body>
</html>
