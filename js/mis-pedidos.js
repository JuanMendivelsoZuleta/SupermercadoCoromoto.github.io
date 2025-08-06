// Funciones específicas para la página de mis pedidos

// Función para mostrar el seguimiento de un pedido
function mostrarSeguimiento(idPedido, estado) {
    const estados = [
        { id: 'pendiente', nombre: 'Pedido Recibido', icono: 'ri-check-line', clase: 'bg-success' },
        { id: 'en_proceso', nombre: 'En Proceso', icono: 'ri-settings-3-line', clase: 'bg-info' },
        { id: 'enviado', nombre: 'En Camino', icono: 'ri-truck-line', clase: 'bg-primary' },
        { id: 'entregado', nombre: 'Entregado', icono: 'ri-home-line', clase: 'bg-success' }
    ];
    
    let html = '<div class="row text-center">';
    
    estados.forEach((est, index) => {
        const isActive = estados.findIndex(e => e.id === estado) >= index;
        const currentClass = isActive ? est.clase : 'bg-light';
        const currentTextClass = isActive ? 'text-white' : 'text-muted';
        
        html += `
            <div class="col-md-3">
                <div class="border rounded p-3 ${currentClass} ${currentTextClass}">
                    <i class="${est.icono}" style="font-size: 1.5rem;"></i><br>
                    <small>${est.nombre}</small>
                </div>
            </div>
        `;
    });
    
    html += '</div>';
    
    document.getElementById('seguimientoContent').innerHTML = html;
    
    // Mostrar el modal
    const modal = new bootstrap.Modal(document.getElementById('seguimientoModal'));
    modal.show();
} 