<?php

include("conexion.php");

// Consulta con JOIN corregido y cantidad
$sql = "SELECT productos.id_producto, productos.nombre, productos.precio, productos.cantidad, productos.imagen, categorias.nombre AS categoria
        FROM productos
        LEFT JOIN categorias ON productos.id_categoria = categorias.id_categoria";

$resultado = mysqli_query($conexion, $sql);
if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de Administración</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h1 class="text-center mb-4">Panel de Administración</h1>

    <div class="d-flex justify-content-end mb-3">
      <a href="agregar_producto.php" class="btn btn-success">Agregar Producto</a>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered table-hover table-striped">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Categoría</th>
            <th>Imagen</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
            <tr>
              <td><?= $fila['id_producto'] ?></td>
              <td><?= htmlspecialchars($fila['nombre']) ?></td>
              <td>$<?= number_format($fila['precio'], 2) ?></td>
              <td><?= intval($fila['cantidad']) ?></td>
              <td><?= htmlspecialchars($fila['categoria']) ?></td>
              <td>
                <?php if (!empty($fila['imagen'])): ?>
                  <img src="../../imagenes/<?= $fila['imagen'] ?>" alt="Imagen" width="80">
                <?php else: ?>
                  <span class="text-muted">Sin imagen</span>
                <?php endif; ?>
              </td>
              <td>
                <a href="editar_producto.php?id=<?= $fila['id_producto'] ?>" class="btn btn-sm btn-primary">Editar</a>
                <a href="eliminar_producto.php?id=<?= $fila['id_producto'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este producto?')">Eliminar</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>