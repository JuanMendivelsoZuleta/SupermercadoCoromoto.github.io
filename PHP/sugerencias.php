<?php
include(__DIR__ . '/../administrador/db.php');
$query = $_GET['q'] ?? '';

if ($query !== '') {
    $stmt = $pdo->prepare("SELECT nombre FROM productos WHERE nombre LIKE ? LIMIT 5");
    $stmt->execute(['%' . $query . '%']);
    $resultados = $stmt->fetchAll(PDO::FETCH_COLUMN);

    foreach ($resultados as $nombre) {
        echo "<a href='#' class='list-group-item list-group-item-action sugerencia-item'>" . htmlspecialchars($nombre) . "</a>";
    }
}
?>