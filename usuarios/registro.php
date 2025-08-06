<?php 
require_once('../administrador/db.php');

$mensaje = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';
    $confirmar_contrasena = $_POST['confirmar_contrasena'] ?? '';

    // Validaciones
    if (empty($nombre) || empty($email) || empty($direccion) || empty($contrasena)) {
        $error = "Por favor, complete todos los campos.";
    } elseif ($contrasena !== $confirmar_contrasena) {
        $error = "Las contraseñas no coinciden.";
    } elseif (strlen($contrasena) < 6) {
        $error = "La contraseña debe tener al menos 6 caracteres.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Por favor, ingrese un email válido.";
    } else {
        try {
            // Verificar si el email ya existe
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuario WHERE correo = ?");
            $stmt->execute([$email]);
            if ($stmt->fetchColumn() > 0) {
                $error = "Este email ya está registrado.";
            } else {
                // Insertar en tabla usuario (usando correo en lugar de nombre)
                $stmt = $pdo->prepare("INSERT INTO usuario (correo, contrasena) VALUES (?, ?)");
                $stmt->execute([$email, $contrasena]);
                $idUsuario = $pdo->lastInsertId();

                // Insertar en cliente
                $stmt2 = $pdo->prepare("INSERT INTO cliente (idUsuario, nombre, direccion, email) VALUES (?, ?, ?, ?)");
                $stmt2->execute([$idUsuario, $nombre, $direccion, $email]);

                $mensaje = "¡Registro exitoso! Ya puedes iniciar sesión.";
            }
        } catch (PDOException $e) {
            $error = "Error en el registro: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Supermercado Coromoto</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/auth.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet"/>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h4>👤 Registro de Usuario</h4>
            </div>
            <div class="auth-body">
                <?php if ($error): ?>
                    <div class="alert-auth alert-danger">
                        <i class="ri-error-warning-line me-2"></i><?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($mensaje): ?>
                    <div class="alert-auth alert-success">
                        <i class="ri-check-line me-2"></i><?= htmlspecialchars($mensaje) ?>
                    </div>
                <?php endif; ?>
                
                <form method="post" class="auth-form needs-validation" novalidate>
                    <div class="form-group">
                        <label for="nombre" class="form-label">Nombre completo</label>
                        <input type="text" 
                               id="nombre"
                               name="nombre" 
                               class="form-control" 
                               value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>"
                               required />
                        <i class="ri-user-line form-icon"></i>
                        <div class="invalid-feedback">
                            Por favor, ingrese su nombre completo.
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" 
                               id="email"
                               name="email" 
                               class="form-control" 
                               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                               required />
                        <i class="ri-mail-line form-icon"></i>
                        <div class="invalid-feedback">
                            Por favor, ingrese un email válido.
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="direccion" class="form-label">Dirección</label>
                        <textarea id="direccion"
                                  name="direccion" 
                                  class="form-control" 
                                  rows="3"
                                  required><?= htmlspecialchars($_POST['direccion'] ?? '') ?></textarea>
                        <i class="ri-map-pin-line form-icon"></i>
                        <div class="invalid-feedback">
                            Por favor, ingrese su dirección.
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="contrasena" class="form-label">Contraseña</label>
                        <input type="password" 
                               id="contrasena"
                               name="contrasena" 
                               class="form-control" 
                               minlength="6"
                               required />
                        <i class="ri-lock-line form-icon"></i>
                        <div class="form-text">Mínimo 6 caracteres</div>
                        <div class="invalid-feedback">
                            La contraseña debe tener al menos 6 caracteres.
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="confirmar_contrasena" class="form-label">Confirmar contraseña</label>
                        <input type="password" 
                               id="confirmar_contrasena"
                               name="confirmar_contrasena" 
                               class="form-control" 
                               required />
                        <i class="ri-lock-password-line form-icon"></i>
                        <div class="invalid-feedback">
                            Por favor, confirme su contraseña.
                        </div>
                    </div>
                    
                    <button class="btn-auth btn-success-auth" type="submit">
                        Registrarse
                    </button>
                </form>
                
                <div class="auth-divider">
                    <span>¿Ya tienes una cuenta?</span>
                </div>
                
                <div class="auth-links">
                    <a href="login.php" class="auth-link">
                        <i class="ri-login-box-line me-2"></i>Iniciar Sesión
                    </a>
                </div>
                
                <div class="text-center">
                    <a href="../index.php" class="auth-back-link">
                        <i class="ri-arrow-left-line me-1"></i>Volver al inicio
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Validación del formulario
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
</body>
</html>
