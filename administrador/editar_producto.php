<?php
include('db.php');

$id = $_GET['id'] ?? null;
if (!$id) {
    die('ID de producto no especificado.');
}

// Obtener datos del producto
$stmt = $pdo->prepare("SELECT * FROM producto WHERE idProducto = ?");
$stmt->execute([$id]);
$producto = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$producto) {
    die('Producto no encontrado.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $precio = $_POST['precio'] ?? '';
    $stock = $_POST['stock'] ?? '';
    $categoria = $_POST['categoria'] ?? '';

    // Imagen nueva o mantener la anterior
    if (!empty($_FILES['imagen']['name'])) {
        $imagen = 'imagenes/' . basename($_FILES['imagen']['name']);
        if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $imagen)) {
            echo "<div class='alert alert-danger'>Error al subir la imagen.</div>";
            $imagen = $producto['imagen'];
        }
    } else {
        $imagen = $producto['imagen'];
    }

    // Actualizar producto
    $stmt = $pdo->prepare("UPDATE producto SET nombre = ?, precio = ?, stock = ?, categoria = ?, imagen = ? WHERE idProducto = ?");
    if (!$stmt->execute([$nombre, $precio, $stock, $categoria, $imagen, $id])) {
        $errorInfo = $stmt->errorInfo();
        echo "<div class='alert alert-danger'>Error SQL: {$errorInfo[2]}</div>";
        exit;
    } else {
        header("Location: admin.php?mensaje=editado");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Producto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <h2 class="text-primary text-center mb-4">Editar Producto</h2>
  <form action="editar_producto.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data" class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Nombre:</label>
      <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($producto['nombre']) ?>" required>
    </div>
    <div class="col-md-3">
      <label class="form-label">Precio:</label>
      <input type="number" step="0.01" name="precio" class="form-control" value="<?= htmlspecialchars($producto['precio']) ?>" required>
    </div>
    <div class="col-md-3">
      <label class="form-label">Stock:</label>
      <input type="number" name="stock" class="form-control" value="<?= htmlspecialchars($producto['stock']) ?>" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Categoría:</label>
      <select name="categoria" class="form-select" required>
        <?php foreach (['granos', 'congelados', 'licores', 'verduras'] as $cat): ?>
          <option value="<?= $cat ?>" <?= $producto['categoria'] === $cat ? 'selected' : '' ?>><?= ucfirst($cat) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-6">
      <label class="form-label">Imagen actual:</label><br>
      <?php if ($producto['imagen']): ?>
        <img src="<?= htmlspecialchars($producto['imagen']) ?>" style="max-width: 100px;"><br>
      <?php endif; ?>
      <label class="form-label mt-2">Cambiar imagen:</label>
      <input type="file" name="imagen" class="form-control" accept="image/*">
    </div>
    <div class="col-12 text-end">
      <button type="submit" class="btn btn-primary">Guardar cambios</button>
      <a href="admin.php" class="btn btn-secondary">Cancelar</a>
    </div>
  </form>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
