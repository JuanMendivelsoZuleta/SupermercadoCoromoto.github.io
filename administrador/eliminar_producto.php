<?php
include('db.php');

if (isset($_GET['id'])) {
    $idProducto = intval($_GET['id']);

    try {
        // Primero obtener información del producto para eliminar la imagen
        $stmt = $pdo->prepare("SELECT imagen FROM producto WHERE idProducto = ?");
        $stmt->execute([$idProducto]);
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($producto) {
            // Eliminar registros relacionados en carritoproducto si existe la tabla
            try {
                $stmt = $pdo->prepare("DELETE FROM carritoproducto WHERE idProducto = ?");
                $stmt->execute([$idProducto]);
                $eliminadosCarrito = $stmt->rowCount();
                if ($eliminadosCarrito > 0) {
                    error_log("Eliminados $eliminadosCarrito registros de carritoproducto para producto ID: $idProducto");
                }
            } catch (PDOException $e) {
                // La tabla carritoproducto no existe, continuar
                error_log("Tabla carritoproducto no encontrada: " . $e->getMessage());
            }
            
            // Eliminar la imagen del servidor si existe
            if (!empty($producto['imagen'])) {
                $rutaImagen = __DIR__ . '/imagenes/' . $producto['imagen'];
                if (file_exists($rutaImagen)) {
                    unlink($rutaImagen);
                }
            }
            
            // Eliminar el producto de la base de datos
            $stmt = $pdo->prepare("DELETE FROM producto WHERE idProducto = ?");
            $stmt->execute([$idProducto]);
            
            if ($stmt->rowCount() > 0) {
                header("Location: admin.php?mensaje=eliminado");
                exit;
            } else {
                header("Location: admin.php?mensaje=no_encontrado");
                exit;
            }
        } else {
            header("Location: admin.php?mensaje=no_encontrado");
            exit;
        }
    } catch (PDOException $e) {
        error_log("Error al eliminar producto: " . $e->getMessage());
        header("Location: admin.php?mensaje=error");
        exit;
    }
} else {
    header("Location: admin.php?mensaje=id_invalido");
    exit;
}
?>
