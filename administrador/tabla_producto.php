<?php
include('db.php');
$idCategoria = $_POST['categoria'] ?? $_GET['categoria'] ?? '';

// Obtener productos filtrados por categoría o todos
if ($idCategoria) {
    $stmt = $pdo->prepare("SELECT p.*, c.nombre as categoria_nombre 
                           FROM producto p 
                           LEFT JOIN categoria c ON p.idCategoria = c.idCategoria 
                           WHERE p.idCategoria = ?");
    $stmt->execute([$idCategoria]);
} else {
    $stmt = $pdo->query("SELECT p.*, c.nombre as categoria_nombre 
                         FROM producto p 
                         LEFT JOIN categoria c ON p.idCategoria = c.idCategoria");
}

$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php if (count($productos) > 0): ?>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Categoría</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $p): ?>
                    <tr>
                        <td><strong>#<?= $p['idProducto'] ?></strong></td>
                        <td>
                            <?php 
                            $rutaImagen = '';
                            if (!empty($p['imagen'])) {
                                // Verificar si la imagen existe
                                $rutaCompleta = __DIR__ . '/' . $p['imagen'];
                                if (file_exists($rutaCompleta)) {
                                    $rutaImagen = $p['imagen'];
                                }
                            }
                            ?>
                            <?php if (!empty($rutaImagen)): ?>
                                <img src="<?= htmlspecialchars($rutaImagen) ?>" class="img-thumbnail" style="max-width: 60px; max-height: 60px; object-fit: cover;" alt="<?= htmlspecialchars($p['nombre']) ?>">
                            <?php else: ?>
                                <div class="bg-light d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                    <i class="ri-image-line text-muted"></i>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <strong><?= htmlspecialchars($p['nombre']) ?></strong>
                            <?php if (!empty($p['descripcion'])): ?>
                                <br><small class="text-muted"><?= htmlspecialchars(substr($p['descripcion'], 0, 50)) ?>...</small>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="fw-bold text-success">$<?= number_format($p['precio'], 0, ',', '.') ?></span>
                        </td>
                        <td>
                            <span class="badge bg-secondary"><?= htmlspecialchars($p['categoria_nombre'] ?? 'Sin categoría') ?></span>
                        </td>
                        <td>
                            <span class="badge bg-<?= $p['stock'] > 10 ? 'success' : ($p['stock'] > 0 ? 'warning' : 'danger') ?>">
                                <?= $p['stock'] ?> unidades
                            </span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <button onclick="loadContent('editar_producto.php?id=<?= $p['idProducto'] ?>')" class="btn btn-sm btn-outline-warning" title="Editar producto">
                                    <i class="ri-edit-line"></i>
                                </button>
                                <a href="eliminar_producto.php?id=<?= $p['idProducto'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar este producto?')" title="Eliminar producto">
                                    <i class="ri-delete-bin-line"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="text-center py-5">
        <i class="ri-store-line text-muted" style="font-size: 4rem;"></i>
        <h4 class="text-muted mt-3">No hay productos</h4>
        <p class="text-muted">No se encontraron productos en esta categoría.</p>
    </div>
<?php endif; ?>
