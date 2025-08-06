<?php 
include('db.php');

// Validar que se recibieron los datos necesarios
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: agregar_producto.php?error=metodo_invalido');
    exit;
}

$nombre = trim($_POST['nombre'] ?? '');
$precio = floatval($_POST['precio'] ?? 0);
$stock = intval($_POST['stock'] ?? 0);
$idCategoria = intval($_POST['idCategoria'] ?? 0);
$imagen = '';

// Validaciones básicas
if (empty($nombre) || $precio <= 0 || $stock < 0 || $idCategoria <= 0) {
    header('Location: agregar_producto.php?error=datos_invalidos');
    exit;
}

// Procesar imagen
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
    $archivo = $_FILES['imagen'];
    $nombreArchivo = $archivo['name'];
    $tipoArchivo = $archivo['type'];
    $tamanoArchivo = $archivo['size'];
    
    // Validar tipo de archivo
    $tiposPermitidos = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
    if (!in_array($tipoArchivo, $tiposPermitidos)) {
        header('Location: agregar_producto.php?error=tipo_archivo_invalido');
        exit;
    }
    
    // Validar tamaño (máximo 5MB)
    if ($tamanoArchivo > 5 * 1024 * 1024) {
        header('Location: agregar_producto.php?error=archivo_muy_grande');
        exit;
    }
    
    // Generar nombre único para evitar conflictos
    $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
    $nombreUnico = uniqid() . '.' . $extension;
    $rutaImagen = 'imagenes/' . $nombreUnico;
    $destino = __DIR__ . '/' . $rutaImagen;
    
    if (move_uploaded_file($archivo['tmp_name'], $destino)) {
        $imagen = $rutaImagen;
    } else {
        header('Location: agregar_producto.php?error=error_subida');
        exit;
    }
} else {
    header('Location: agregar_producto.php?error=imagen_requerida');
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO producto (nombre, precio, stock, idCategoria, imagen) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nombre, $precio, $stock, $idCategoria, $imagen]);
    
    // Redirigir con mensaje de éxito
    header('Location: admin.php?mensaje=agregado');
    exit;
    
} catch (PDOException $e) {
    // Si hay error en la base de datos, eliminar la imagen subida
    if (!empty($imagen) && file_exists(__DIR__ . '/' . $imagen)) {
        unlink(__DIR__ . '/' . $imagen);
    }
    
    error_log("Error al guardar producto: " . $e->getMessage());
    header('Location: agregar_producto.php?error=error_bd');
    exit;
}
?>
