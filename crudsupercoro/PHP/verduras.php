<?php
include('../administrador/db.php');
session_start();

// Obtener productos de la categoría 'granos'
$stmt = $pdo->prepare("SELECT * FROM productos WHERE categoria = ?");
$stmt->execute(['verduras']);
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Incluir cabecera
include('../templates/cabecera.php');
?>

<h1 class="text-primary text-center mt-4 mb-3">Verduras</h1>

<div class="container mt-4">
  <div class="row">
    <?php if (!empty($productos)): ?>
      <?php foreach ($productos as $producto): ?>
        <div class="col-md-3 mb-4">
          <div class="card h-100">
            <img src="../administrador/<?= htmlspecialchars($producto['imagen']) ?>" class="card-img-top" style="height: 150px; object-fit: cover;">
            <div class="card-body text-center">
              <h5 class="card-title"><?= htmlspecialchars($producto['nombre']) ?></h5>
              <p class="card-text">$<?= number_format($producto['precio'], 0, ',', '.') ?></p>
              <a href="../carrito/agregar_carrito.php?id=<?= $producto['id'] ?>" class="btn btn-success">Agregar al carrito</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-center">No hay productos disponibles en esta categoría.</p>
    <?php endif; ?>
  </div>

  <div class="text-end mt-4">
    <a href="../carrito/carrito.php" class="btn btn-warning">🛒 Ver carrito</a>
  </div>
</div>

<?php include('../templates/footer.php');?>