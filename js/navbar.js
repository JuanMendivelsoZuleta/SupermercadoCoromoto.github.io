// Funciones globales para la navegación y elementos de la interfaz
// Maneja efectos visuales, scroll, menús y contadores del carrito

document.addEventListener('DOMContentLoaded', function() {
    
    // Ajustar el espaciado del contenido para compensar las barras fijas
    function adjustBodyPadding() {
        const header = document.querySelector('header');
        const nav = document.querySelector('nav');
        
        if (header && nav) {
            const headerHeight = header.offsetHeight;
            const navHeight = nav.offsetHeight;
            const totalHeight = headerHeight + navHeight + 10; // Espacio adicional
            
            // Aplicar padding al body para evitar que el contenido se oculte
            document.body.style.paddingTop = totalHeight + 'px';
        }
    }
    
    // Aplicar ajuste al cargar la página
    adjustBodyPadding();
    
    // Reajustar cuando cambie el tamaño de la ventana
    window.addEventListener('resize', adjustBodyPadding);
    
    // Efectos visuales en el header y navegación durante el scroll
    let lastScrollTop = 0;
    window.addEventListener('scroll', function() {
        const header = document.querySelector('header');
        const nav = document.querySelector('nav');
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        // Aplicar sombra y transparencia al header según el scroll
        if (header) {
            if (scrollTop > 10) {
                header.style.boxShadow = '0 2px 20px rgba(0,0,0,0.1)';
                header.style.background = 'rgba(255, 255, 255, 0.98)';
            } else {
                header.style.boxShadow = 'var(--shadow-sm)';
                header.style.background = 'rgba(255, 255, 255, 0.95)';
            }
        }
        
        // Aplicar sombra a la navegación según el scroll
        if (nav) {
            if (scrollTop > 10) {
                nav.style.boxShadow = '0 4px 20px rgba(0,0,0,0.15)';
            } else {
                nav.style.boxShadow = 'var(--shadow-lg)';
            }
        }
        
        lastScrollTop = scrollTop;
    });
    
    // Navegación suave para enlaces internos (anclas)
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                // Calcular offset para compensar las barras fijas
                const headerHeight = document.querySelector('header').offsetHeight;
                const navHeight = document.querySelector('nav').offsetHeight;
                const offset = headerHeight + navHeight + 20;
                
                // Scroll suave hacia el elemento objetivo
                window.scrollTo({
                    top: target.offsetTop - offset,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Mejorar la funcionalidad del menú desplegable en dispositivos móviles
    const menuItems = document.querySelectorAll('.menu-horizontal > li');
    menuItems.forEach(item => {
        const link = item.querySelector('a');
        const submenu = item.querySelector('.menu-vertical');
        
        // En móviles, hacer que el menú se expanda/contraiga al hacer click
        if (submenu && window.innerWidth <= 768) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
            });
        }
    });
    
    // Crear indicador visual del progreso de scroll
    const createScrollIndicator = () => {
        const indicator = document.createElement('div');
        indicator.id = 'scroll-indicator';
        indicator.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 3px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            z-index: 1001;
            transition: width 0.1s ease;
        `;
        document.body.appendChild(indicator);
        
        // Actualizar el ancho del indicador según el progreso del scroll
        window.addEventListener('scroll', () => {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            const docHeight = document.documentElement.scrollHeight - window.innerHeight;
            const scrollPercent = (scrollTop / docHeight) * 100;
            indicator.style.width = scrollPercent + '%';
        });
    };
    
    // Inicializar el indicador de scroll
    createScrollIndicator();
    
    // Función para actualizar el contador de productos en el carrito
    function actualizarContadorCarrito() {
        const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
        const totalItems = carrito.reduce((total, item) => total + item.cantidad, 0);
        
        // Buscar el enlace del carrito y actualizar su badge
        const carritoLink = document.querySelector('a[href*="/carrito.php"]');
        if (carritoLink) {
            let badge = carritoLink.querySelector('.carrito-badge');
            if (!badge) {
                badge = document.createElement('span');
                badge.className = 'carrito-badge';
                carritoLink.style.position = 'relative';
                carritoLink.appendChild(badge);
            }
            
            // Mostrar u ocultar el badge según si hay productos
            if (totalItems > 0) {
                badge.textContent = totalItems;
                badge.style.display = 'flex';
            } else {
                badge.style.display = 'none';
            }
        }
    }
    
    // Actualizar contador al cargar la página
    actualizarContadorCarrito();
    
    // Hacer la función disponible globalmente para otras páginas
    window.actualizarContadorCarrito = actualizarContadorCarrito;
    
    // Función para cargar contenido dinámicamente (usada en el panel de administración)
    function loadContent(url) {
        fetch(url)
            .then(response => response.text())
            .then(html => {
                document.getElementById("contenido").innerHTML = html;
            })
            .catch(error => console.error('Error al cargar contenido:', error));
    }
    
    // Hacer la función disponible globalmente
    window.loadContent = loadContent;
}); 