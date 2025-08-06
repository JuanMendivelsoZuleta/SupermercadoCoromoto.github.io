<?php
// Incluir archivos necesarios para la funcionalidad del carrito
include('administrador/db.php');
include('templates/cabecera.php');
?>
<!-- Enlaces a estilos y scripts específicos del carrito -->
<link rel="stylesheet" href="<?= $BASE ?>/css/carrito.css">
<script src="<?= $BASE ?>/js/carrito-functions.js" defer></script>

<!-- Contenedor principal del carrito de compras -->
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- Encabezado del carrito -->
                <div class="card-header">
                    <h2 class="mb-0">
                        <i class="fa-solid fa-shopping-cart me-2"></i>
                        Mi Carrito de Compras
                    </h2>
                </div>
                <div class="card-body">
                    <!-- Mensaje cuando el carrito está vacío -->
                    <div id="carrito-vacio" class="text-center py-5" style="display: none;">
                        <i class="fa-solid fa-shopping-cart fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">Tu carrito está vacío</h4>
                        <p class="text-muted">No hay productos en tu carrito. ¡Agrega algunos productos para comenzar!</p>
                        <a href="<?= $BASE ?>/index.php" class="btn btn-primary">
                            <i class="fa-solid fa-home me-2"></i>Ir a la tienda
                        </a>
                    </div>
                    
                    <!-- Contenido del carrito cuando hay productos -->
                    <div id="carrito-contenido" style="display: none;">
                        <!-- Tabla de productos en el carrito -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Producto</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>Subtotal</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="carrito-tabla">
                                    <!-- Los productos se cargarán dinámicamente desde JavaScript -->
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Controles del carrito y resumen de compra -->
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <!-- Botón para vaciar todo el carrito -->
                                <button id="vaciar-carrito" class="btn btn-outline-danger">
                                    <i class="fa-solid fa-trash me-2"></i>Vaciar carrito
                                </button>
                            </div>
                            <div class="col-md-6 text-end">
                                <!-- Resumen del total y botón de compra -->
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h5 class="card-title">Total del carrito</h5>
                                        <h3 class="text-success" id="total-carrito">$0.00</h3>
                                        <button id="procesar-compra" class="btn btn-success btn-lg w-100">
                                            <i class="fa-solid fa-credit-card me-2"></i>Procesar compra
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('templates/footer.php'); ?> 