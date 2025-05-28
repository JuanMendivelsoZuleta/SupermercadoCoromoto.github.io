<?php
include(__DIR__ . '/../usuarios/includes/admin_check.php');
include('db.php');
$stmtCat = $pdo->query("SELECT DISTINCT categoria FROM productos");
$categorias = $stmtCat->fetchAll(PDO::FETCH_COLUMN);
$filtro = $_GET['categoria'] ?? '';
if ($filtro) {
    $stmt = $pdo->prepare("SELECT * FROM productos WHERE categoria = ?");
    $stmt->execute([$filtro]);
} else {
    $stmt = $pdo->query("SELECT * FROM productos");
}
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>



  <meta charset="UTF-8">
  <title>Productos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


  <h1 class="text-center text-primary mb-4">Inventario de Productos</h1>
  <form class="row mb-4" method="GET">
    <div class="col-md-4 offset-md-4">
      <select name="categoria" class="form-select" onchange="this.form.submit()">
        <option value="">-- Todas las categorías --</option>
        <?php foreach ($categorias as $cat): ?>
          <option value="<?= $cat ?>" <?= $filtro == $cat ? 'selected' : '' ?>><?= ucfirst($cat) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </form>
  <div class="mb-3 text-end">
    <button class="btn btn-success" onclick="loadContent('agregar_producto.php')">➕ Agregar nuevo producto</button>
  </div>
  <table class="table table-bordered table-hover text-center align-middle">
    <thead class="table-primary">
      <tr><th>Imagen</th><th>Nombre</th><th>Precio</th><th>Stock</th><th>Categoría</th><th>Acciones</th></tr>
    </thead>
    <tbody>
      <?php foreach ($productos as $p): ?>
        <tr>
          <td><?php if ($p['imagen']): ?><img src="<?= $p['imagen'] ?>" class="img-thumbnail" style="max-width: 100px;"><?php else: ?><em>Sin imagen</em><?php endif; ?></td>
          <td><?= htmlspecialchars($p['nombre']) ?></td>
          <td>$<?= number_format($p['precio'], 0, ',', '.') ?></td>
          <td><?= $p['stock'] ?></td>
          <td><?= ucfirst($p['categoria']) ?></td>
          <td>
            <a onclick="loadContent('./editar_producto.php?id=<?= $p['id'] ?>')" class="btn btn-sm btn-warning">✏️ Editar</a>
            <a href="eliminar_producto.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este producto?')">🗑️ Eliminar</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>