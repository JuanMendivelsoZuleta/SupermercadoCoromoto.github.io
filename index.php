<?php include('./templates/cabecera.php'); ?>

<div class="container-fluid">
    <section class="bienvenida fade-in">
        <h1 class="titulo-bienvenida">¡BIENVENIDOS AL SUPERMERCADO COROMOTO!</h1>
        <h2 class="subtitulo-bienvenida">
            🌟 ¡Donde ahorrar es una realidad! 🌟<br>
            ¡Aprovecha nuestras increíbles ofertas y promociones TODOS LOS DÍAS!
        </h2>
        <div class="imagenes-promocion">
            <img src="./img/pro1.png" alt="Clientes comprando felices" class="slide-in">
            <img src="./img/pro2.png" alt="Persona con carrito lleno de frutas" class="slide-in">
            <img src="./img/pro3.png" alt="Carrito con productos variados" class="slide-in">
        </div>
        
        <div class="mt-4">
            <a href="categorias.php" class="btn btn-primary btn-lg me-3">
                <i class="ri-store-line me-2"></i>Ver Productos
            </a>
            <a href="usuarios/registro.php" class="btn btn-warning btn-lg">
                <i class="ri-user-add-line me-2"></i>Registrarse
            </a>
        </div>
    </section>


    <!-- Sección de características -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">¿Por qué elegir Supermercado Coromoto?</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <i class="ri-price-tag-3-line text-primary" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                            <h5 class="card-title">Mejores Precios</h5>
                            <p class="card-text">Ofrecemos los precios más competitivos del mercado para que ahorres en cada compra.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <i class="ri-truck-line text-success" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                            <h5 class="card-title">Entrega Rápida</h5>
                            <p class="card-text">Recibe tus productos en la puerta de tu casa con nuestro servicio de entrega express.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <i class="ri-shield-check-line text-warning" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                            <h5 class="card-title">Calidad Garantizada</h5>
                            <p class="card-text">Todos nuestros productos son de la más alta calidad y frescura garantizada.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>



<?php include('./templates/footer.php'); ?>