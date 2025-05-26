<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $clave = $_POST['clave'];

    // CORREGIDO: puerto 3309 incluido
    $pdo = new PDO("mysql:host=localhost;port=3309;dbname=carritosupermercado;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && $clave === $usuario['clave']) {
        $_SESSION['usuario'] = [
            'id' => $usuario['id'],
            'nombre' => $usuario['nombre'],
            'email' => $usuario['email'],
            'rol' => $usuario['rol']
        ];
        header("Location: ../administrador/admin.php");
        exit();
    } else {
        $error = "Credenciales incorrectas.";
    }
}
?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head><body class="container mt-5">
<h2 class="mb-4 text-primary text-center">Iniciar sesión</h2>
<?php if (!empty($error)): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
<form method="POST" class="row g-3">
  <div class="col-12"><label>Email:</label><input type="email" name="email" class="form-control" required></div>
  <div class="col-12"><label>Contraseña:</label><input type="password" name="clave" class="form-control" required></div>
  <div class="col-12 text-end">
    <button type="submit" class="btn btn-primary">Entrar</button>
  </div>
</form></body></html>
