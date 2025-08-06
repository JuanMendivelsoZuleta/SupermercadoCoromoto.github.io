<?php
include(__DIR__ . '/../administrador/db.php');
include(__DIR__ . '/../templates/cabecera.php');

// Obtener el término de búsqueda
$busqueda = isset($_GET['q']) ? trim($_GET['q']) : '';

// Si no hay término de búsqueda, redirigir al inicio
if (empty($busqueda)) {
    header('Location: ' . $BASE . '/index.php');
    exit;
}

try {
    // Preparar la consulta de búsqueda
    $sql = "SELECT p.*, c.nombre as categoria_nombre 
            FROM producto p 
            LEFT JOIN categoria c ON p.idCategoria = c.idCategoria 
            WHERE p.nombre LIKE :busqueda 
            OR p.descripcion LIKE :busqueda 
            OR c.nombre LIKE :busqueda 
            ORDER BY p.nombre ASC";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['busqueda' => '%' . $busqueda . '%']);
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    error_log("Error en búsqueda: " . $e->getMessage());
    $productos = [];
}
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">
                        <i class="fa-solid fa-search me-2"></i>
                        Resultados de búsqueda para: "<strong><?= htmlspecialchars($busqueda) ?></strong>"
                    </h2>
                    <p class="text-muted mb-0">
                        <?= count($productos) ?> producto<?= count($productos) != 1 ? 's' : '' ?> encontrado<?= count($productos) != 1 ? 's' : '' ?>
                    </p>
                </div>
                <div class="card-body">
                    <?php if (empty($productos)): ?>
                        <div class="text-center py-5">
                            <i class="fa-solid fa-search fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">No se encontraron productos</h4>
                            <p class="text-muted">
                                No se encontraron productos que coincidan con "<strong><?= htmlspecialchars($busqueda) ?></strong>"
                            </p>
                            <a href="<?= $BASE ?>/index.php" class="btn btn-primary">
                                <i class="fa-solid fa-home me-2"></i>Volver al inicio
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="row">
                            <?php foreach ($productos as $producto): ?>
                                <div class="col-md-4 col-lg-3 mb-4">
                                    <div class="card h-100 product-card">
                                        <div class="position-relative">
                                            <?php if (!empty($producto['imagen'])): ?>
                                                <img src="<?= $BASE ?>/administrador/<?= htmlspecialchars($producto['imagen']) ?>" 
                                                     class="card-img-top" 
                                                     alt="<?= htmlspecialchars($producto['nombre']) ?>"
                                                     style="height: 200px; object-fit: cover;"
                                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                <div class="card-img-top d-none align-items-center justify-content-center" 
                                                     style="height: 200px; background-color: #f8f9fa;">
                                                    <i class="fa-solid fa-image text-muted" style="font-size: 3rem;"></i>
                                                </div>
                                            <?php else: ?>
                                                <div class="card-img-top d-flex align-items-center justify-content-center" 
                                                     style="height: 200px; background-color: #f8f9fa;">
                                                    <i class="fa-solid fa-image text-muted" style="font-size: 3rem;"></i>
                                                </div>
                                            <?php endif; ?>
                                            <?php if (!empty($producto['categoria_nombre'])): ?>
                                                <span class="badge bg-primary position-absolute top-0 end-0 m-2">
                                                    <?= htmlspecialchars($producto['categoria_nombre']) ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title"><?= htmlspecialchars($producto['nombre']) ?></h5>
                                            <p class="card-text text-muted small">
                                                <?= htmlspecialchars(substr($producto['descripcion'], 0, 100)) ?>
                                                <?= strlen($producto['descripcion']) > 100 ? '...' : '' ?>
                                            </p>
                                            <div class="mt-auto">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <span class="h5 text-success mb-0">
                                                        $<?= number_format($producto['precio'], 2) ?>
                                                    </span>
                                                    <small class="text-muted">
                                                        Stock: <?= $producto['stock'] ?>
                                                    </small>
                                                </div>
                                                <button class="btn btn-success w-100 add-to-cart" 
                                                        data-product-id="<?= $producto['idProducto'] ?>"
                                                        data-product-name="<?= htmlspecialchars($producto['nombre']) ?>"
                                                        data-product-price="<?= $producto['precio'] ?>"
                                                        data-product-image="<?= htmlspecialchars($producto['imagen']) ?>">
                                                    <i class="fa-solid fa-cart-plus me-2"></i>Agregar al carrito
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="text-center mt-4">
                            <a href="<?= $BASE ?>/index.php" class="btn btn-outline-primary">
                                <i class="fa-solid fa-home me-2"></i>Volver al inicio
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.product-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid #e9ecef;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.card-img-top {
    transition: transform 0.3s ease;
}

.product-card:hover .card-img-top {
    transform: scale(1.05);
}

.badge {
    font-size: 0.75rem;
}
</style>



<?php include(__DIR__ . '/../templates/footer.php'); ?> 