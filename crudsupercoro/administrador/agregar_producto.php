<?php
include('db.php');
$stmt = $pdo->query("SELECT DISTINCT categoria FROM productos");
$categorias = $stmt->fetchAll(PDO::FETCH_COLUMN);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Agregar Producto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
  <h2 class="text-primary text-center mb-4">Agregar Nuevo Producto</h2>
  <form action="guardar_producto.php" method="POST" enctype="multipart/form-data" class="row g-3">
    <div class="col-md-6"><label class="form-label">Nombre:</label><input type="text" name="nombre" class="form-control" required></div>
    <div class="col-md-3"><label class="form-label">Precio:</label><input type="number" step="0.01" name="precio" class="form-control" required></div>
    <div class="col-md-3"><label class="form-label">Stock:</label><input type="number" name="stock" class="form-control" required></div>
    <div class="col-md-6">
      <label class="form-label">Categoría:</label>
      <select name="categoria" class="form-select" required>
        <option value="">Seleccionar</option>
        <?php foreach ($categorias as $cat): ?>
        <option value="<?= $cat ?>"><?= ucfirst($cat) ?></option>
        <?php endforeach; ?>
        <option value="granos">Granos</option>
        <option value="congelados">Congelados</option>
        <option value="verduras">Verduras</option>
        <option value="licores">Licores</option>
      </select>
    </div>
    <div class="col-md-6"><label class="form-label">Imagen:</label><input type="file" name="imagen" class="form-control" accept="image/*" required></div>
    <div class="col-12 text-end">
      <button type="submit" class="btn btn-success">Guardar Producto</button>
      <a href="listar_productos.php" class="btn btn-secondary">Volver</a>
    </div>
  </form>
</body>
</html>