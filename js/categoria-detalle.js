// Funciones específicas para la página de detalle de categoría

// Funcionalidad para ver detalles del producto
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.view-product').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            
            // Aquí puedes agregar la lógica para mostrar detalles del producto
            // Por ejemplo, abrir un modal o redirigir a una página de detalles
            alert(`Ver detalles del producto ID: ${productId}`);
        });
    });
}); 