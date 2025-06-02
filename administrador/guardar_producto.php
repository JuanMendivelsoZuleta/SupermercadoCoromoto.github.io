<?php
include('db.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $categoria = strtolower($_POST['categoria']);
    $imagen = $_FILES['imagen'];
    $ruta_destino = 'imagenes/' . basename($imagen['name']);
    if (move_uploaded_file($imagen['tmp_name'], $ruta_destino)) {
        $stmt = $pdo->prepare("INSERT INTO productos (nombre, precio, stock, categoria, imagen) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nombre, $precio, $stock, $categoria, $ruta_destino]);
        echo "✅ Producto guardado exitosamente.";
        header("Location: admin.php?mensaje=agregado");
exit();
    } else {
        echo "❌ Error al subir la imagen.";
    }
}
?>