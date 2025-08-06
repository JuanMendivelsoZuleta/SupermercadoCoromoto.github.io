// Funciones para la gestión del carrito de compras
// Maneja la carga, modificación y sincronización de productos en el carrito

// Cargar y mostrar los productos del carrito desde el almacenamiento local
function cargarCarrito() {
    const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    const carritoVacio = document.getElementById('carrito-vacio');
    const carritoContenido = document.getElementById('carrito-contenido');
    const carritoTabla = document.getElementById('carrito-tabla');
    const totalCarrito = document.getElementById('total-carrito');
    
    // Mostrar mensaje de carrito vacío si no hay productos
    if (carrito.length === 0) {
        carritoVacio.style.display = 'block';
        carritoContenido.style.display = 'none';
        return;
    }
    
    // Mostrar contenido del carrito
    carritoVacio.style.display = 'none';
    carritoContenido.style.display = 'block';
    
    let html = '';
    let total = 0;
    
    // Generar HTML para cada producto en el carrito
    carrito.forEach(item => {
        const subtotal = item.precio * item.cantidad;
        total += subtotal;
        
        html += `
            <tr class="carrito-item" data-id="${item.id}">
                <td>
                    <div class="d-flex align-items-center">
                        ${item.imagen ? 
                            `<img src="${window.location.origin}/SupermercadoCoromoto/administrador/${item.imagen}" 
                                  class="producto-imagen me-3" alt="${item.nombre}">` :
                            `<div class="producto-imagen me-3 bg-light d-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-image text-muted"></i>
                             </div>`
                        }
                        <div>
                            <h6 class="mb-0">${item.nombre}</h6>
                            <small class="text-muted">Producto</small>
                        </div>
                    </div>
                </td>
                <td class="align-middle">
                    <span class="fw-bold">$${item.precio.toFixed(2)}</span>
                </td>
                <td class="align-middle">
                    <div class="cantidad-control d-flex">
                        <button class="btn-cantidad" onclick="cambiarCantidad('${item.id}', -1)">-</button>
                        <input type="number" class="form-control input-cantidad" value="${item.cantidad}" 
                               min="1" onchange="cambiarCantidad('${item.id}', this.value - ${item.cantidad})">
                        <button class="btn-cantidad" onclick="cambiarCantidad('${item.id}', 1)">+</button>
                    </div>
                </td>
                <td class="align-middle">
                    <span class="fw-bold text-success">$${subtotal.toFixed(2)}</span>
                </td>
                <td class="align-middle">
                    <button class="btn btn-sm btn-outline-danger btn-eliminar" onclick="eliminarProducto('${item.id}')">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
    });
    
    // Actualizar la tabla y el total
    carritoTabla.innerHTML = html;
    totalCarrito.textContent = `$${total.toFixed(2)}`;
}

// Modificar la cantidad de un producto específico
function cambiarCantidad(id, cambio) {
    const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    const producto = carrito.find(item => item.id === id);
    
    if (producto) {
        const nuevaCantidad = producto.cantidad + cambio;
        if (nuevaCantidad > 0) {
            // Actualizar cantidad y guardar en localStorage
            producto.cantidad = nuevaCantidad;
            localStorage.setItem('carrito', JSON.stringify(carrito));
            cargarCarrito();
            actualizarContadorCarrito();
        } else if (nuevaCantidad === 0) {
            // Eliminar producto si la cantidad llega a 0
            eliminarProducto(id);
        }
    }
}

// Eliminar un producto específico del carrito con confirmación
function eliminarProducto(id) {
    Swal.fire({
        title: '¿Eliminar producto?',
        text: "¿Estás seguro de que quieres eliminar este producto del carrito?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Filtrar el producto eliminado y actualizar localStorage
            const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
            const nuevoCarrito = carrito.filter(item => item.id !== id);
            localStorage.setItem('carrito', JSON.stringify(nuevoCarrito));
            cargarCarrito();
            actualizarContadorCarrito();
            
            Swal.fire(
                '¡Eliminado!',
                'El producto ha sido eliminado del carrito.',
                'success'
            );
        }
    });
}

// Actualizar el contador de productos en el header
function actualizarContadorCarrito() {
    if (window.actualizarContadorCarrito) {
        window.actualizarContadorCarrito();
    }
}

// Vaciar completamente el carrito con confirmación
function vaciarCarrito() {
    Swal.fire({
        title: '¿Vaciar carrito?',
        text: "¿Estás seguro de que quieres vaciar todo el carrito?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, vaciar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Eliminar todo el carrito del localStorage
            localStorage.removeItem('carrito');
            cargarCarrito();
            actualizarContadorCarrito();
            
            Swal.fire(
                '¡Carrito vaciado!',
                'Todos los productos han sido eliminados del carrito.',
                'success'
            );
        }
    });
}

// Inicialización cuando se carga la página
document.addEventListener('DOMContentLoaded', function() {
    // Cargar el carrito al iniciar
    cargarCarrito();
    
    // Configurar botón para vaciar carrito
    const btnVaciarCarrito = document.getElementById('vaciar-carrito');
    if (btnVaciarCarrito) {
        btnVaciarCarrito.addEventListener('click', vaciarCarrito);
    }
    
    // Configurar botón para procesar compra
    const btnProcesarCompra = document.getElementById('procesar-compra');
    if (btnProcesarCompra) {
        btnProcesarCompra.addEventListener('click', function() {
            const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
            
            // Verificar que hay productos en el carrito
            if (carrito.length === 0) {
                Swal.fire('Error', 'No hay productos en el carrito', 'error');
                return;
            }
            
            // Verificar que el usuario esté autenticado
            const usuarioLogueado = document.querySelector('.user-welcome') !== null;
            if (!usuarioLogueado) {
                Swal.fire({
                    title: 'Inicia sesión',
                    text: 'Debes iniciar sesión para continuar con la compra',
                    icon: 'warning',
                    confirmButtonText: 'Iniciar sesión',
                    cancelButtonText: 'Cancelar',
                    showCancelButton: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/SupermercadoCoromoto/usuarios/login.php';
                    }
                });
                return;
            }
            
            // Sincronizar carrito con el servidor antes de continuar
            fetch('/SupermercadoCoromoto/carrito/sincronizar_carrito.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(carrito)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Redirigir al proceso de compra
                    window.location.href = '/SupermercadoCoromoto/carrito/finalizar_compra.php';
                } else {
                    Swal.fire('Error', 'Error al sincronizar el carrito', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Error al sincronizar el carrito', 'error');
            });
        });
    }
}); 