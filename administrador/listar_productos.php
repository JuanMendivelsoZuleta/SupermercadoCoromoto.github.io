<?php
include(__DIR__ . '/../usuarios/includes/admin_check.php');
include('db.php');

// Obtener categorías de la tabla categoria
try {
    $stmtCat = $pdo->query("SELECT idCategoria, nombre FROM categoria ORDER BY nombre");
    $categorias = $stmtCat->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $categorias = [];
    error_log("Error al obtener categorías: " . $e->getMessage());
}
?>

<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header bg-success text-white">
          <h2 class="mb-0">
            <i class="ri-store-line me-2"></i>
            Inventario de Productos
          </h2>
        </div>
        <div class="card-body">
          <form class="row mb-4" id="filtroForm">
            <div class="col-md-4 offset-md-4">
              <select name="categoria" class="form-select" id="categoriaSelect">
                <option value="">-- Todas las categorías --</option>
                <?php if (!empty($categorias)): ?>
                  <?php foreach ($categorias as $cat): ?>
                    <option value="<?= $cat['idCategoria'] ?>"><?= htmlspecialchars($cat['nombre']) ?></option>
                  <?php endforeach; ?>
                <?php endif; ?>
              </select>
            </div>
          </form>
          
          <div class="mb-3 text-end">
            <button class="btn btn-success" onclick="loadContent('agregar_producto.php')">
              <i class="ri-add-line me-1"></i>Agregar nuevo producto
            </button>
          </div>
          
          <div id="tablaProductos">
            <?php include 'tabla_producto.php'; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const categoriaSelect = document.getElementById('categoriaSelect');
  if (categoriaSelect) {
    categoriaSelect.addEventListener('change', function() {
      console.log('Seleccionaste:', this.value);
      fetch('tabla_producto.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'categoria=' + encodeURIComponent(this.value)
      })
      .then(response => response.text())
      .then(data => {
        document.getElementById('tablaProductos').innerHTML = data;
      })
      .catch(error => {
        console.error('Error:', error);
      });
    });
  }
});
</script>