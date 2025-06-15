<?php
include(__DIR__ . '/../administrador/db.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$query = $_GET['q'] ?? '';
$stmt = $pdo->prepare("SELECT * FROM productos WHERE nombre LIKE ?");
$stmt->execute(['%' . $query . '%']);
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Resultados de búsqueda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/crudsupercoro/css/styles.css">
</head>
<body>
<?php include('../templates/cabecera.php'); ?>

<h2 class="text-center text-primary mt-4">Resultados para: "<?= htmlspecialchars($query) ?>"</h2>

<div class="row p-4">
    <?php if (count($resultados) > 0): ?>
        <?php foreach ($resultados as $producto): ?>
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <img src="../administrador/<?= $producto['imagen'] ?>" class="card-img-top" style="height: 150px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h5 class="card-title"><?= htmlspecialchars($producto['nombre']) ?></h5>
                        <p class="card-text">$<?= number_format($producto['precio'], 0, ',', '.') ?></p>
                        <a href="../carrito/agregar_carrito.php?id=<?= $producto['id'] ?>" class="btn btn-success">Agregar al carrito</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-center">No se encontraron resultados.</p>
    <?php endif; ?>
</div>

<?php include('../templates/footer.php'); ?>
</body>
</html>
