document.addEventListener('DOMContentLoaded', () => {
    // Selecciona todos los enlaces con la clase 'agregar-carrito'
    const enlacesAgregar = document.querySelectorAll('.agregar-carrito');

    enlacesAgregar.forEach(enlace => {
        enlace.addEventListener('click', async (event) => {
            event.preventDefault(); 

            const productoId = event.target.dataset.id;
            const productoNombre = event.target.dataset.nombre;

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
                // Envía el ID del producto a tu script PHP de agregar al carrito
                const response = await fetch(`../carrito/agregar_carrito.php?id=${productoId}`, {
                    method: 'GET' // O 'POST' si tu script PHP espera POST
                    // Si usas POST, deberías enviar un objeto FormData o JSON:
                    // body: JSON.stringify({ id: productoId }),
                    // headers: { 'Content-Type': 'application/json' }
                });

                if (!response.ok) {
                    throw new Error(`Error de red: ${response.statusText}`);
                }

                const data = await response.json(); // Asume que tu PHP devuelve JSON

                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Producto Agregado!',
                        text: `"${productoNombre}" ha sido añadido al carrito.`,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    // Aquí podrías actualizar el contador del carrito, etc.
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: data.message || 'No se pudo agregar el producto al carrito.',
                        confirmButtonText: 'Aceptar'
                    });
                }

            } catch (error) {
                console.error('Error al agregar al carrito:', error);
                Swal.fire({
                    icon: 'error',
                    title: '¡Algo salió mal!',
                    text: 'Hubo un problema de conexión o servidor.',
                    confirmButtonText: 'Aceptar'
                });
            }
        });
    });
});