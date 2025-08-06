<?php
include('../usuarios/includes/admin_check.php');
include('db.php');

// Unir cliente con usuario
$stmt = $pdo->query("SELECT u.idUsuario, c.nombre, c.email, 'cliente' AS rol
                     FROM usuario u
                     INNER JOIN cliente c ON u.idUsuario = c.idUsuario
                     UNION
                     SELECT u.idUsuario, a.nombreAdm AS nombre, '' AS email, 'admin' AS rol
                     FROM usuario u
                     INNER JOIN administrador a ON u.idUsuario = a.idUsuario
                     ORDER BY idUsuario DESC");

$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header bg-info text-white">
          <h2 class="mb-0">
            <i class="ri-user-line me-2"></i>
            Lista de Usuarios
          </h2>
        </div>
        <div class="card-body">
          <?php if (count($usuarios) > 0): ?>
            <div class="table-responsive">
              <table class="table table-striped table-hover">
                <thead class="table-dark">
                  <tr>
                    <th>ID Usuario</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Estado</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                      <td><strong>#<?= htmlspecialchars($usuario['idUsuario']) ?></strong></td>
                      <td><?= htmlspecialchars($usuario['nombre']) ?></td>
                      <td>
                        <?php if (!empty($usuario['email'])): ?>
                          <i class="ri-mail-line me-1"></i><?= htmlspecialchars($usuario['email']) ?>
                        <?php else: ?>
                          <span class="text-muted">No disponible</span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <span class="badge bg-<?= $usuario['rol'] === 'admin' ? 'danger' : 'primary' ?>">
                          <i class="ri-<?= $usuario['rol'] === 'admin' ? 'admin-line' : 'user-line' ?> me-1"></i>
                          <?= ucfirst(htmlspecialchars($usuario['rol'])) ?>
                        </span>
                      </td>
                      <td>
                        <span class="badge bg-success">
                          <i class="ri-check-line me-1"></i>Activo
                        </span>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          <?php else: ?>
            <div class="text-center py-5">
              <i class="ri-user-line text-muted" style="font-size: 4rem;"></i>
              <h4 class="text-muted mt-3">No hay usuarios registrados</h4>
              <p class="text-muted">Aún no se han registrado usuarios en el sistema.</p>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
