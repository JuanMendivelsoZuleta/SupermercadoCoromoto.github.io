<?php
include(__DIR__ . '/../usuarios/includes/admin_check.php');
include('db.php');
$stmtCat = $pdo->query("SELECT DISTINCT categoria FROM productos");
$categorias = $stmtCat->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
</head>
<body>

<h1 class="text-center text-primary mb-4">Inventario de Productos</h1>
<form class="row mb-4" id="filtroForm">
  <div class="col-md-4 offset-md-4">
    <select name="categoria" class="form-select" id="categoriaSelect">
      <option value="">-- Todas las categorías --</option>
      <?php foreach ($categorias as $cat): ?>
        <option value="<?= $cat ?>"><?= ucfirst($cat) ?></option>
      <?php endforeach; ?>
    </select>
  </div>
</form>
<div class="mb-3 text-end">
  <button class="btn btn-success" onclick="loadContent('agregar_producto.php')">➕ Agregar nuevo producto</button>
</div>
<div id="tablaProductos">
  <?php include 'tabla_productos.php'; ?>
</div>

<script>
$(document).on('change', '#categoriaSelect', function() {
  console.log('Seleccionaste:', this.value); // <-- Depuración
  $.get('tabla_productos.php', {categoria: this.value}, function(data) {
    $('#tablaProductos').html(data);
  });
});
</script>

</body>
</html>