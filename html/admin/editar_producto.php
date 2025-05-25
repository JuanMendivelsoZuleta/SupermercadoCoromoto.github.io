<?php
include "conexion.php";

$id = intval($_GET['id']);
$producto = $conexion->query("SELECT * FROM productos WHERE id_producto = $id")->fetch_assoc();

if (isset($_POST['guardar'])) {
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $precio = floatval($_POST['precio']);
    $cantidad = intval($_POST['cantidad']);
    $id_categoria = intval($_POST['id_categoria']);

    // Manejo de imagen
    if (!empty($_FILES['imagen']['name'])) {
        $imagen = $_FILES['imagen']['name'];
        $tmp = $_FILES['imagen']['tmp_name'];
        move_uploaded_file($tmp, "../../imagenes/" . $imagen);
    } else {
        $imagen = $producto['imagen'];
    }

    $sql = "UPDATE productos SET 
                nombre='$nombre', 
                precio=$precio, 
                cantidad=$cantidad, 
                imagen='$imagen', 
                id_categoria=$id_categoria 
            WHERE id_producto = $id";
    if ($conexion->query($sql)) {
        echo "<div class='alert alert-success'>Producto actualizado. Redirigiendo...</div>";
        echo "<script>setTimeout(function(){ window.location.href = 'panelAdmin.php'; }, 1500);</script>";
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conexion->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2>Editar producto</h2>
        <form action="" method="POST" enctype="multipart/form-data" class="mb-3">
            <div class="mb-2">
                Nombre: <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($producto['nombre']) ?>" required>
            </div>
            <div class="mb-2">
                Precio: <input type="number" name="precio" class="form-control" step="0.01" value="<?= $producto['precio'] ?>" required>
            </div>
            <div class="mb-2">
                Cantidad: <input type="number" name="cantidad" class="form-control" value="<?= $producto['cantidad'] ?>" required>
            </div>
            <div class="mb-2">
                Imagen actual:<br>
                <?php if (!empty($producto['imagen'])): ?>
                    <img src="../../imagenes/<?= $producto['imagen'] ?>" alt="Imagen" width="80"><br>
                <?php else: ?>
                    <span class="text-muted">Sin imagen</span><br>
                <?php endif; ?>
                Cambiar imagen: <input type="file" name="imagen" class="form-control">
                <small class="text-muted">Deja vacío para mantener la imagen actual.</small>
            </div>
            <div class="mb-2">
                Categoría:
                <select name="id_categoria" class="form-select" required>
                    <option value="">Seleccione una categoría</option>
                    <?php
                    $res = $conexion->query("SELECT * FROM categorias");
                    while ($cat = $res->fetch_assoc()) {
                        $selected = $cat['id_categoria'] == $producto['id_categoria'] ? "selected" : "";
                        echo "<option value='{$cat['id_categoria']}' $selected>{$cat['nombre']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" name="guardar" class="btn btn-success">Guardar Cambios</button>
            <a href="panelAdmin.php" class="btn btn-secondary ms-2">Volver al Panel</a>
        </form>
    </div>
</body>
</html>