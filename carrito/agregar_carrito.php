<?php
// Asegúrate de incluir tu conexión a la base de datos y de iniciar la sesión
include('../administrador/db.php'); // Asegúrate de que esta ruta sea correcta
session_start();

header('Content-Type: application/json'); // Siempre respondemos con JSON

$response = ['status' => 'error', 'message' => '', 'carritoHtml' => '', 'totalItems' => 0];

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $producto_id = intval($_GET['id']); // Asegurarse de que sea un entero

    // 1. Lógica para añadir el producto al carrito (sin cambios significativos)
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    if (isset($_SESSION['carrito'][$producto_id])) {
        $_SESSION['carrito'][$producto_id]++;
    } else {
        $_SESSION['carrito'][$producto_id] = 1;
    }

    // 2. Generar el HTML del carrito actualizado
    ob_start(); // Inicia el buffer de salida

    $carrito_actual = $_SESSION['carrito'];
    $productos_en_carrito = [];
    $total = 0;
    $total_items = 0;

    if (!empty($carrito_actual)) {
        $ids = implode(',', array_keys($carrito_actual));
        // Aquí debes asegurarte de que $pdo esté disponible, que viene de db.php
        $stmt = $pdo->query("SELECT id, nombre, precio, imagen FROM productos WHERE id IN ($ids)");
        $productos_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Reorganizar productos_db para facilitar el acceso por ID
        $productos_map = [];
        foreach ($productos_db as $prod) {
            $productos_map[$prod['id']] = $prod;
        }

        ?>
        <table class="table table-bordered text-center align-middle">
            <thead class="table-light">
                <tr><th>Imagen</th><th>Producto</th><th>Precio</th><th>Cantidad</th><th>Subtotal</th><th>Eliminar</th></tr>
            </thead>
            <tbody>
                <?php foreach ($carrito_actual as $id => $cantidad):
                    // Asegúrate de que el producto exista en la base de datos
                    if (isset($productos_map[$id])):
                        $producto = $productos_map[$id];
                        $subtotal = $producto['precio'] * $cantidad;
                        $total += $subtotal;
                        $total_items += $cantidad; // Suma la cantidad para el contador
                ?>
                <tr>
                    <td><img src="../administrador/<?= htmlspecialchars($producto['imagen']) ?>" width="80" style="object-fit: cover;"></td>
                    <td><?= htmlspecialchars($producto['nombre']) ?></td>
                    <td>$<?= number_format($producto['precio'], 0, ',', '.') ?></td>
                    <td>
                        <form action="actualizar_carrito.php" method="POST" class="d-flex justify-content-center align-items-center">
                            <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                            <input type="number" name="cantidad" value="<?= $cantidad ?>" min="1" class="form-control form-control-sm w-50 me-1">
                            <button type="submit" class="btn btn-sm btn-primary">↺</button>
                        </form>
                    </td>
                    <td>$<?= number_format($subtotal, 0, ',', '.') ?></td>
                    <td><a href="quitar_producto.php?id=<?= $producto['id'] ?>" class="btn btn-sm btn-danger">🗑️</a></td>
                </tr>
                <?php
                    endif; 
                endforeach; ?>
            </tbody>
        </table>
        <div class="text-end">
            <h4>Total: $<?= number_format($total, 0, ',', '.') ?></h4>
            <a href="vaciar_carrito.php" class="btn btn-outline-danger me-2">Vaciar carrito</a>
            <a href="finalizar_compra.php" class="btn btn-success">Finalizar compra</a>
        </div>
        <?php
    } else {
        // Mensaje si el carrito está vacío después de alguna operación
        echo '<div class="alert alert-warning text-center">Tu carrito está vacío.</div>';
        echo '<div class="text-center"><a href="../index.php" class="btn btn-primary">Ir a la tienda</a></div>';
    }

    $response['carritoHtml'] = ob_get_clean(); // Guarda el contenido del buffer y lo limpia
    $response['totalItems'] = $total_items;
    $response['status'] = 'success';
    $response['message'] = 'Producto agregado al carrito con éxito.';

} else {
    $response['message'] = 'ID de producto no válido.';
}

echo json_encode($response);
exit; // Asegura que no se envíe nada más
?>