<?php
include('../usuarios/includes/admin_check.php');
include('db.php');

$stmt = $pdo->query("SELECT id, nombre, email, rol FROM usuarios ORDER BY id DESC");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Usuarios</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
  <h2 class="text-center text-primary mb-4">👥 Usuarios Registrados</h2>
  <table class="table table-bordered text-center align-middle">
    <thead class="table-light">
      <tr><th>ID</th><th>Nombre</th><th>Email</th><th>Rol</th></tr>
    </thead>
    <tbody>
      <?php foreach ($usuarios as $u): ?>
        <tr>
          <td><?= $u['id'] ?></td>
          <td><?= htmlspecialchars($u['nombre']) ?></td>
          <td><?= htmlspecialchars($u['email']) ?></td>
          <td><?= ucfirst($u['rol']) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <div class="text-center">
    <a href="admin.php" class="btn btn-secondary">← Volver</a>
  </div>
</body>
</html>
