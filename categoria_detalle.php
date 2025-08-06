<?php 
include('./templates/cabecera.php');
include('./administrador/db.php');
?>
<link rel="stylesheet" href="<?= $BASE ?>/css/categoria-detalle.css">
<script src="<?= $BASE ?>/js/categoria-detalle.js" defer></script>
<?php

// Obtener el ID de la categoría
$idCategoria = intval($_GET['id'] ?? 0);

if ($idCategoria <= 0) {
    header('Location: categorias.php');
    exit;
}

// Obtener información de la categoría
try {
    $stmt = $pdo->prepare("SELECT * FROM categoria WHERE idCategoria = ?");
    $stmt->execute([$idCategoria]);
    $categoria = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$categoria) {
        header('Location: categorias.php');
        exit;
    }
} catch (PDOException $e) {
    header('Location: categorias.php');
    exit;
}

// Obtener productos de la categoría
try {
    $stmt = $pdo->prepare("SELECT p.*, c.nombre as categoria_nombre 
                           FROM producto p 
                           LEFT JOIN categoria c ON p.idCategoria = c.idCategoria 
                           WHERE p.idCategoria = ? 
                           ORDER BY p.nombre");
    $stmt->execute([$idCategoria]);
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $productos = [];
}

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

<div class="container-fluid">
    <!-- Header de la categoría -->
    <section class="py-5 bg-gradient-primary text-white">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <div class="categoria-header-icon mb-4">
                        <i class="<?= $icono ?>" style="font-size: 4rem;"></i>
                    </div>
                                         <h1 class="display-4 fw-bold mb-3"><?= htmlspecialchars($categoria['nombre']) ?></h1>
                     <p class="lead mb-4"><?= htmlspecialchars($categoria['descripcion']) ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Productos de la categoría -->
    <section class="py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h2 class="mb-0">
                        <i class="ri-shopping-bag-line me-2 text-primary"></i>
                        Productos en <?= htmlspecialchars($categoria['nombre']) ?>
                    </h2>
                </div>
                <div class="col-md-6 text-end">
                    <span class="badge bg-primary fs-6">
                        <?= count($productos) ?> producto<?= count($productos) != 1 ? 's' : '' ?>
                    </span>
                </div>
            </div>

            <?php if (empty($productos)): ?>
                <div class="text-center py-5">
                    <i class="ri-inbox-line text-muted" style="font-size: 4rem;"></i>
                    <h3 class="mt-3 text-muted">No hay productos en esta categoría</h3>
                    <p class="text-muted">Pronto agregaremos productos a esta categoría.</p>
                    <a href="<?= $BASE ?>/categorias.php" class="btn btn-primary">
                        <i class="ri-arrow-left-line me-1"></i>
                        Volver a categorías
                    </a>
                </div>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($productos as $producto): ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="card h-100 product-card shadow-sm hover-lift">
                                <div class="product-image-container">
                                    <?php if (!empty($producto['imagen'])): ?>
                                        <img src="<?= $BASE ?>/administrador/<?= htmlspecialchars($producto['imagen']) ?>" 
                                             class="card-img-top product-image" 
                                             alt="<?= htmlspecialchars($producto['nombre']) ?>">
                                    <?php else: ?>
                                        <div class="card-img-top product-image-placeholder d-flex align-items-center justify-content-center">
                                            <i class="ri-image-line text-muted" style="font-size: 3rem;"></i>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Badge de stock -->
                                    <?php if ($producto['stock'] <= 0): ?>
                                        <div class="product-badge product-badge-out-of-stock">
                                            <i class="ri-close-circle-line me-1"></i>Agotado
                                        </div>
                                    <?php elseif ($producto['stock'] <= 5): ?>
                                        <div class="product-badge product-badge-low-stock">
                                            <i class="ri-error-warning-line me-1"></i>Últimas unidades
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title product-title">
                                        <?= htmlspecialchars($producto['nombre']) ?>
                                    </h5>
                                    
                                    <?php if (!empty($producto['descripcion'])): ?>
                                        <p class="card-text text-muted small">
                                            <?= htmlspecialchars(substr($producto['descripcion'], 0, 100)) ?>
                                            <?= strlen($producto['descripcion']) > 100 ? '...' : '' ?>
                                        </p>
                                    <?php endif; ?>
                                    
                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="product-price fs-5 fw-bold text-success">
                                                $<?= number_format($producto['precio'], 0, ',', '.') ?>
                                            </span>
                                            <small class="text-muted">
                                                Stock: <?= $producto['stock'] ?>
                                            </small>
                                        </div>
                                        
                                        <div class="d-grid gap-2">
                                            <?php if ($producto['stock'] > 0): ?>
                                                <button class="btn btn-primary btn-sm add-to-cart" 
                                                        data-product-id="<?= $producto['idProducto'] ?>"
                                                        data-product-name="<?= htmlspecialchars($producto['nombre']) ?>"
                                                        data-product-price="<?= $producto['precio'] ?>"
                                                        data-product-image="<?= htmlspecialchars($producto['imagen']) ?>">
                                                    <i class="ri-shopping-cart-line me-1"></i>
                                                    Agregar al carrito
                                                </button>
                                            <?php else: ?>
                                                <button class="btn btn-secondary btn-sm" disabled>
                                                    <i class="ri-close-circle-line me-1"></i>
                                                    Agotado
                                                </button>
                                            <?php endif; ?>
                                            
                                            <button class="btn btn-outline-info btn-sm view-product" 
                                                    data-product-id="<?= $producto['idProducto'] ?>">
                                                <i class="ri-eye-line me-1"></i>
                                                Ver detalles
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Sección de navegación -->
    <section class="py-4 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <a href="<?= $BASE ?>/categorias.php" class="btn btn-outline-primary me-3">
                        <i class="ri-arrow-left-line me-1"></i>
                        Ver todas las categorías
                    </a>
                    <a href="<?= $BASE ?>/index.php" class="btn btn-outline-secondary">
                        <i class="ri-home-line me-1"></i>
                        Volver al inicio
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>



<?php include('./templates/footer.php'); ?> 