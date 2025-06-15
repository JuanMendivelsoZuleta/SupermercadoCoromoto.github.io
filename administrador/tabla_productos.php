<?php
include('db.php');
$categoria = $_GET['categoria'] ?? '';
if ($categoria) {
    $stmt = $pdo->prepare("SELECT * FROM productos WHERE categoria = ?");
    $stmt->execute([$categoria]);
} else {
    $stmt = $pdo->query("SELECT * FROM productos");
}
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
</head>

<body>
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
</body>
</html>