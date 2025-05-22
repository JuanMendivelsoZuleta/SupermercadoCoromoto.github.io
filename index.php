<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="./css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet"/>
    <script src="https://kit.fontawesome.com/4ed7a0ea78.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <div class="logo">
            <a href="/coromotosuper/index.php"><img src="imagenes/coromoto-removebg-preview.png" width="140" height="100" alt="logo"></a>
            <figcaption>Supermercado <br> Coromoto</figcaption>
        </div>
        <div class="container">
            <form>
                <input type="text" placeholder="¿Qué estás buscando?...">
                <button>
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
        </div>
        <div class="botonuser">
            <a href="html/register.html"><button><i class="fa-solid fa-user"></i></button></a>
            <button id="cart-icon">
                <i class="fa-solid fa-cart-shopping"></i>
                <span class="cart-item-count"></span>
            </button>
            <a href="#"><button><i class="fa-solid fa-right-to-bracket"></i></button></a>
        </div>
    </header>
    <nav>
        <ul class="menu-horizontal">
            <li><a href="/coromotosuper/index.php">Inicio</a></li>
            <li>
                <a href="#">Categorías</a>
                <ul class="menu-vertical">
                    <li><a href="html/granos.html">Granos</a></li>
                    <li><a href="html/verduras.html">Verduras</a></li>
                    <li><a href="html/congelados.html">Congelados</a></li>
                    <li><a href="html/licores.html">Licores</a></li>
                </ul>
            </li>
            <li><a href="html/contacto.html" target="_blank">Contáctanos</a></li>
        </ul>
    </nav>

    <!-- BLOQUE DE BIENVENIDA -->
    <section class="bienvenida">
        <h1 class="titulo-bienvenida">¡BIENVENIDOS AL SUPERMERCADO COROMOTO!</h1>
        <h2 class="subtitulo-bienvenida">
            🌟 ¡Donde ahorrar es una realidad! 🌟<br>
            ¡Aprovecha nuestras increíbles ofertas y promociones TODOS LOS DÍAS!
        </h2>
        <div class="imagenes-promocion">
            <img src="imagenes/pro1.png" alt="Clientes comprando felices">
            <img src="imagenes/pro2.png" alt="Persona con carrito lleno de frutas">
            <img src="imagenes/pro3.png" alt="Carrito con productos variados">
        </div>
    </section>
    <!-- FIN BLOQUE DE BIENVENIDA -->

    <div class="cart">
        <h2 class="cart-title">Tu carrito</h2>
        <div class="cart-content">
            <!-- Aquí irán los productos del carrito -->
        </div>
        <div class="total">
            <div class="total-title">Total</div>
            <div class="total-price">$0</div>
        </div>
        <button class="btn-buy">Comprar ahora</button>
        <i class="ri-close-line" id="cart-close"></i>
    </div>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <a href="https://api.whatsapp.com/send?phone=1234567891&text=Hola, me gustaria obtener más información" class="float" target="_blank">
        <i class="fa fa-whatsapp my-float "></i>
    </a>

    <footer>
        <div class="social">
            <a href="https://maps.app.goo.gl/No8SVMXGehRu1QX79" target="_blank">
                <i class="fa-solid fa-location-dot"></i>
            </a>
            <a href="#" target="_blank">
                <i class="fa-brands fa-facebook"></i>
            </a>
            <a href="#" target="_blank">
                <i class="fa-brands fa-twitter"></i>
            </a>
            <a href="#" target="_blank">
                <i class="fa-brands fa-instagram"></i>
            </a>
        </div>
        <div class="copy">
            <p>&copy; Supermercado Coromoto</p>
        </div>
    </footer>

    <script src="script.js" defer></script>
</body>
</html>
