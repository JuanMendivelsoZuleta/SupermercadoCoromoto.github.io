<?php 
include('./templates/cabecera.php');
include('./administrador/db.php');

// Obtener todas las categorías
try {
    $stmt = $pdo->query("SELECT * FROM categoria ORDER BY nombre");
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $categorias = [];
    error_log("Error al obtener categorías: " . $e->getMessage());
}

// Obtener productos por categoría
function obtenerProductosPorCategoria($pdo, $idCategoria) {
    try {
        $stmt = $pdo->prepare("SELECT p.*, c.nombre as categoria_nombre 
                               FROM producto p 
                               LEFT JOIN categoria c ON p.idCategoria = c.idCategoria 
                               WHERE p.idCategoria = ? 
                               ORDER BY p.nombre 
                               LIMIT 6");
        $stmt->execute([$idCategoria]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}
?>

<div class="container-fluid">
    <!-- Header de la página -->
    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                                         <h1 class="display-4 fw-bold mb-3">
                         <i class="ri-apps-line me-3"></i>Nuestras Categorías
                     </h1>
                     <p class="lead">Explora todos nuestros productos organizados por categorías</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Grid de categorías -->
    <section class="py-5">
        <div class="container">
            <?php if (empty($categorias)): ?>
                <div class="text-center py-5">
                    <i class="ri-error-warning-line text-warning" style="font-size: 4rem;"></i>
                    <h3 class="mt-3">No hay categorías disponibles</h3>
                    <p class="text-muted">Por favor, contacta al administrador para agregar categorías.</p>
                </div>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($categorias as $categoria): ?>
                        <?php 
                        $productos = obtenerProductosPorCategoria($pdo, $categoria['idCategoria']);
                        $totalProductos = count($productos);
                        ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100 shadow-sm hover-lift">
                                <div class="card-header bg-gradient-primary text-white text-center py-4">
                                    <div class="categoria-icon mb-3">
                                        <?php
                                        // Iconos específicos para cada categoría
                                        $iconos = [
                                            'Verduras y Hortalizas' => 'ri-plant-line',
                                            'Frutas' => 'ri-apple-line',
                                            'Carnes y Pescados' => 'ri-fish-line',
                                            'Lácteos' => 'ri-cup-line',
                                            'Panadería' => 'ri-bread-line',
                                            'Licores y Bebidas Alcohólicas' => 'ri-wine-line',
                                            'Bebidas' => 'ri-drinks-line',
                                            'Productos de Limpieza' => 'ri-brush-line',
                                            'Productos de Higiene Personal' => 'ri-shower-line',
                                            'Snacks y Golosinas' => 'ri-cookie-line',
                                            'Conservas' => 'ri-can-line',
                                            'Condimentos y Especias' => 'ri-seasoning-line',
                                            'Granos y Cereales' => 'ri-seed-line',
                                            'Congelados' => 'ri-snowy-line',
                                            'Dulces y Mermeladas' => 'ri-cake-line'
                                        ];
                                        $icono = $iconos[$categoria['nombre']] ?? 'ri-apps-line';
                                        ?>
                                        <i class="<?= $icono ?>" style="font-size: 3rem;"></i>
                                    </div>
                                    <h4 class="card-title mb-0"><?= htmlspecialchars($categoria['nombre']) ?></h4>
                                </div>
                                <div class="card-body">
                                    <p class="card-text text-muted">
                                        <?= htmlspecialchars($categoria['descripcion']) ?>
                                    </p>
                                    
                                    <?php if ($totalProductos > 0): ?>
                                        <div class="productos-preview mb-3">
                                            <h6 class="text-primary mb-2">
                                                <i class="ri-shopping-bag-line me-1"></i>
                                                Productos destacados (<?= $totalProductos ?>)
                                            </h6>
                                            <div class="row">
                                                <?php foreach (array_slice($productos, 0, 3) as $producto): ?>
                                                    <div class="col-4 mb-2">
                                                        <div class="producto-mini text-center">
                                                            <?php if (!empty($producto['imagen'])): ?>
                                                                <img src="<?= $BASE ?>/administrador/<?= htmlspecialchars($producto['imagen']) ?>" 
                                                                     alt="<?= htmlspecialchars($producto['nombre']) ?>"
                                                                     class="img-fluid rounded" 
                                                                     style="max-width: 60px; max-height: 60px; object-fit: cover;">
                                                            <?php else: ?>
                                                                <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                                     style="width: 60px; height: 60px;">
                                                                    <i class="ri-image-line text-muted"></i>
                                                                </div>
                                                            <?php endif; ?>
                                                            <small class="d-block text-truncate mt-1">
                                                                <?= htmlspecialchars($producto['nombre']) ?>
                                                            </small>
                                                            <small class="text-success fw-bold">
                                                                $<?= number_format($producto['precio'], 0, ',', '.') ?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                            <?php if ($totalProductos > 3): ?>
                                                <small class="text-muted">
                                                    Y <?= $totalProductos - 3 ?> productos más...
                                                </small>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-center py-3">
                                            <i class="ri-inbox-line text-muted" style="font-size: 2rem;"></i>
                                            <p class="text-muted mb-0">No hay productos en esta categoría</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="card-footer bg-transparent border-0 text-center">
                                    <a href="categoria_detalle.php?id=<?= $categoria['idCategoria'] ?>" 
                                       class="btn btn-primary btn-sm">
                                        <i class="ri-eye-line me-1"></i>
                                        Ver todos los productos
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Sección de estadísticas -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4 mb-4">
                    <div class="stat-card">
                        <i class="ri-apps-line text-primary" style="font-size: 3rem;"></i>
                        <h3 class="mt-3"><?= count($categorias) ?></h3>
                        <p class="text-muted">Categorías disponibles</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="stat-card">
                        <i class="ri-shopping-bag-line text-success" style="font-size: 3rem;"></i>
                        <h3 class="mt-3">
                            <?php
                            try {
                                $stmt = $pdo->query("SELECT COUNT(*) FROM producto");
                                echo $stmt->fetchColumn();
                            } catch (PDOException $e) {
                                echo "0";
                            }
                            ?>
                        </h3>
                        <p class="text-muted">Productos totales</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="stat-card">
                        <i class="ri-customer-service-line text-warning" style="font-size: 3rem;"></i>
                        <h3 class="mt-3">24/7</h3>
                        <p class="text-muted">Atención al cliente</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
.hover-lift {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}

.categoria-icon {
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.producto-mini img {
    border: 1px solid #dee2e6;
}

.stat-card {
    padding: 2rem;
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

 .stat-card:hover {
     transform: translateY(-3px);
 }
</style>

<?php include('./templates/footer.php'); ?> 