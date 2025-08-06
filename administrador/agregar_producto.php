<?php
include('db.php');

// Obtener categorías de la tabla categoria
try {
    $stmt = $pdo->query("SELECT idCategoria, nombre, descripcion FROM categoria ORDER BY nombre");
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $categorias = []; // Array vacío si falla la consulta
    error_log("Error al obtener categorías: " . $e->getMessage());
}

// Función para obtener mensaje de error
function getErrorMessage($error) {
    switch ($error) {
        case 'metodo_invalido':
            return 'Método de acceso inválido.';
        case 'datos_invalidos':
            return 'Por favor, complete todos los campos correctamente.';
        case 'tipo_archivo_invalido':
            return 'Solo se permiten archivos de imagen (JPG, PNG, GIF).';
        case 'archivo_muy_grande':
            return 'El archivo es demasiado grande. Máximo 5MB.';
        case 'error_subida':
            return 'Error al subir la imagen. Intente nuevamente.';
        case 'imagen_requerida':
            return 'Debe seleccionar una imagen.';
        case 'error_bd':
            return 'Error en la base de datos. Intente nuevamente.';
        default:
            return 'Ha ocurrido un error inesperado.';
    }
}

?>
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header bg-success text-white">
          <h2 class="mb-0">
            <i class="ri-add-line me-2"></i>
            Agregar Nuevo Producto
          </h2>
        </div>
        <div class="card-body">
          <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>Error:</strong> <?= htmlspecialchars(getErrorMessage($_GET['error'])) ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php endif; ?>

          <form action="guardar_producto.php" class="row g-3" enctype="multipart/form-data" method="POST">
            <div class="col-md-6">
              <label class="form-label">
                <i class="ri-price-tag-line me-1"></i>Nombre del producto:
              </label>
              <input class="form-control" name="nombre" required="" type="text" placeholder="Ej: Leche entera"/>
            </div>
            
            <div class="col-md-3">
              <label class="form-label">
                <i class="ri-money-dollar-circle-line me-1"></i>Precio:
              </label>
              <input class="form-control" name="precio" required="" step="0.01" type="number" min="0" placeholder="0.00"/>
            </div>
            
            <div class="col-md-3">
              <label class="form-label">
                <i class="ri-stack-line me-1"></i>Stock:
              </label>
              <input class="form-control" name="stock" required="" type="number" min="0" placeholder="0"/>
            </div>
            
            <div class="col-md-6">
              <label class="form-label">
                <i class="ri-folder-line me-1"></i>Categoría:
              </label>
              <select class="form-select" name="idCategoria" required="">
                <option value="">Seleccionar categoría</option>
                <?php if (!empty($categorias)): ?>
                  <?php foreach ($categorias as $cat): ?>
                    <option value="<?= htmlspecialchars($cat['idCategoria']) ?>">
                      <?= htmlspecialchars($cat['nombre']) ?>
                      <?php if (!empty($cat['descripcion'])): ?>
                        - <?= htmlspecialchars($cat['descripcion']) ?>
                      <?php endif; ?>
                    </option>
                  <?php endforeach; ?>
                <?php else: ?>
                  <option value="" disabled>No hay categorías disponibles</option>
                <?php endif; ?>
              </select>
              <small class="form-text text-muted">Selecciona la categoría que mejor describe el producto</small>
            </div>
            
            <div class="col-md-6">
              <label class="form-label">
                <i class="ri-image-line me-1"></i>Imagen del producto:
              </label>
              <input accept="image/*" class="form-control" name="imagen" required="" type="file"/>
              <small class="form-text text-muted">Formatos permitidos: JPG, PNG, GIF. Máximo 5MB.</small>
            </div>
            
            <div class="col-12">
              <label class="form-label">
                <i class="ri-file-text-line me-1"></i>Descripción (opcional):
              </label>
              <textarea class="form-control" name="descripcion" rows="3" placeholder="Describe el producto..."></textarea>
            </div>
            
            <div class="col-12 text-end">
              <button class="btn btn-secondary me-2" type="button" onclick="loadContent('listar_productos.php')">
                <i class="ri-arrow-left-line me-1"></i>Volver
              </button>
              <button class="btn btn-success" type="submit">
                <i class="ri-save-line me-1"></i>Guardar Producto
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
