<?php
 include "conexion.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2>Agregar nuevo producto</h2>
        <form action="" method="POST" enctype="multipart/form-data" class="mb-3">
            <div class="mb-2">
                Nombre: <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="mb-2">
                Precio: <input type="number" name="precio" class="form-control" step="0.01" required>
            </div>
             <div class="mb-2">
                Cantidad: <input type="number" name="cantidad" class="form-control"  required>
            </div>
            <div class="mb-2">
                Imagen: <input type="file" name="imagen" class="form-control" required>
            </div>
            <div class="mb-2">
                Categoría:
                <select name="id_categoria" class="form-select" required>
                    <option value="">Seleccione una categoría</option>
                    <?php
                    $res = $conexion->query("SELECT * FROM categorias");
                    while ($cat = $res->fetch_assoc()) {
                        echo "<option value='{$cat['id_categoria']}'>{$cat['nombre']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" name="guardar" class="btn btn-success">Guardar</button>
            <a href="panelAdmin.php" class="btn btn-secondary ms-2">Volver al Panel</a>
        </form>

        <?php
        if (isset($_POST['guardar'])) {
            $nombre = $conexion->real_escape_string($_POST['nombre']);
            $precio = floatval($_POST['precio']);
            $id_categoria = intval($_POST['id_categoria']);
            $imagen = $_FILES['imagen']['name'];
            $tmp = $_FILES['imagen']['tmp_name'];
            $cantidad = intval($_POST['cantidad']);


        if ($imagen && move_uploaded_file($tmp, "../../imagenes/" . $imagen)) {
            $sql = "INSERT INTO productos (nombre, precio, cantidad, imagen, id_categoria)
                    VALUES ('$nombre', $precio, $cantidad, '$imagen', $id_categoria)";
            if ($conexion->query($sql)) {
                echo "<div class='alert alert-success'>Producto agregado con éxito. Redirigiendo...</div>";
                echo "<script>setTimeout(function(){ window.location.href = 'panelAdmin.php'; }, 1500);</script>";
            } else {
                echo "<div class='alert alert-danger'>Error: " . $conexion->error . "</div>";
            }
        } else {
            echo "<div class='alert alert-warning'>Error al subir la imagen.</div>";
        }}
        ?>
    </div>
</body>
</html>