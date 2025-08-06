// Funciones para agregar productos al carrito desde las páginas de productos
// Maneja la interacción con botones "Agregar al carrito" y la gestión del localStorage

document.addEventListener('DOMContentLoaded', () => {
    // Buscar todos los botones de agregar al carrito en la página
    const botonesAgregar = document.querySelectorAll('.add-to-cart');

    // Configurar evento click para cada botón
    botonesAgregar.forEach(boton => {
        boton.addEventListener('click', async (event) => {
            event.preventDefault(); 

            // Obtener información del producto desde los atributos del botón
            const productoId = event.target.dataset.productId || event.target.dataset.id;
            const productoNombre = event.target.dataset.productName || event.target.dataset.nombre;

            // Mostrar confirmación antes de agregar al carrito
            const { isConfirmed } = await Swal.fire({
                title: '¿Quieres agregar este producto al carrito?',
                text: `Estás a punto de agregar "${productoNombre}" a tu carrito.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, ¡agregar!',
                cancelButtonText: 'Cancelar'
            });

            if (!isConfirmed) {
                return; 
            }

            try {
                // Obtener el carrito actual del almacenamiento local
                let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
                
                // Verificar si el producto ya existe en el carrito
                const productoExistente = carrito.find(item => String(item.id) === String(productoId));
                
                if (productoExistente) {
                    // Incrementar cantidad si el producto ya existe
                    productoExistente.cantidad += 1;
                } else {
                    // Obtener datos adicionales del producto desde el botón
                    const precio = event.target.dataset.productPrice || event.target.dataset.precio;
                    const imagen = event.target.dataset.productImage || event.target.dataset.imagen;
                    
                    // Agregar nuevo producto al carrito
                    carrito.push({
                        id: productoId,
                        nombre: productoNombre,
                        precio: parseFloat(precio) || 0,
                        imagen: imagen || '',
                        cantidad: 1
                    });
                }
                
                // Guardar el carrito actualizado en el almacenamiento local
                localStorage.setItem('carrito', JSON.stringify(carrito));
                
                // Mostrar notificación de éxito al usuario
                Swal.fire({
                    icon: 'success',
                    title: '¡Producto Agregado!',
                    text: `"${productoNombre}" ha sido añadido al carrito.`,
                    showConfirmButton: false,
                    timer: 1500,
                    toast: true,
                    position: 'top-end',
                    background: '#28a745',
                    color: '#fff',
                    iconColor: '#fff'
                });
                
                // Actualizar el contador del carrito en el header si existe la función
                if (typeof window.actualizarContadorCarrito === 'function') {
                    window.actualizarContadorCarrito();
                }

            } catch (error) {
                // Manejar errores y mostrar mensaje al usuario
                console.error('Error al agregar al carrito:', error);
                Swal.fire({
                    icon: 'error',
                    title: '¡Algo salió mal!',
                    text: 'Hubo un problema al agregar el producto al carrito.',
                    confirmButtonText: 'Aceptar'
                });
            }
        });
    });
});