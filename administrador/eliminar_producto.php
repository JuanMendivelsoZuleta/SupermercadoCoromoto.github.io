<?php
// Incluir db.php desde la misma carpeta
include('db.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    try {
        $stmt = $pdo->prepare("DELETE FROM productos WHERE id = ?");
        $stmt->execute([$id]);
        if ($stmt->rowCount() > 0) {
    // No mostrar mensaje aquí
    header("Location: admin.php?mensaje=eliminado");
    exit;
} else {
    header("Location: admin.php?mensaje=no_encontrado");
    exit;
}
    } catch (PDOException $e) {
        echo "Error al eliminar producto: " . $e->getMessage();
    }
} else {
    echo "ID no válido.";
}
?>
