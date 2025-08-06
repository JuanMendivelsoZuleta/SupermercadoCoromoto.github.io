<?php
session_start();
require_once('../administrador/db.php');

$error = "";
$email_value = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';
    $email_value = $email; // Guardar el email para mostrarlo en caso de error

    if (empty($email) || empty($contrasena)) {
        $error = "Por favor, complete todos los campos.";
    } else {
        // Obtener usuario por email - corregida la consulta para usar la estructura correcta
        $stmt = $pdo->prepare("SELECT u.idUsuario, u.contrasena, c.nombre, c.email 
                               FROM usuario u
                               INNER JOIN cliente c ON u.idUsuario = c.idUsuario
                               WHERE u.correo = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && $usuario['contrasena'] === $contrasena) {
            // Asegurar que el nombre esté disponible
            $nombre = $usuario['nombre'] ?? 'Usuario';
            
            $_SESSION['usuario'] = [
                'idUsuario' => $usuario['idUsuario'],
                'nombre' => $nombre,
                'email' => $usuario['email']
            ];

            // Verificar si también es administrador
            $adminStmt = $pdo->prepare("SELECT COUNT(*) FROM administrador WHERE idUsuario = ?");
            $adminStmt->execute([$usuario['idUsuario']]);
            $esAdmin = $adminStmt->fetchColumn() > 0;

            if ($esAdmin) {
                $_SESSION['usuario']['esAdmin'] = true;
                header("Location: ../administrador/admin.php");
            } else {
                header("Location: ../index.php");
            }
            exit;
        } else {
            $error = "Email o contraseña incorrectos.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Supermercado Coromoto</title>
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
                <h4><i class="ri-lock-line me-2"></i>Iniciar Sesión</h4>
                <p class="auth-subtitle">Bienvenido de vuelta a Supermercado Coromoto</p>
            </div>
            <div class="auth-body">
                <?php if ($error): ?>
                    <div class="alert-auth alert-danger">
                        <i class="ri-error-warning-line me-2"></i><?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
                
                <form method="post" class="auth-form" id="loginForm">
                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="ri-mail-line me-1"></i>Email
                        </label>
                        <div class="input-wrapper">
                            <input type="email" 
                                   id="email"
                                   name="email" 
                                   class="form-control <?= $error && empty($email_value) ? 'is-invalid' : '' ?>" 
                                   value="<?= htmlspecialchars($email_value) ?>"
                                   placeholder="ejemplo@correo.com"
                                   required />
                            <i class="ri-mail-line form-icon"></i>
                        </div>
                        <?php if ($error && empty($email_value)): ?>
                            <div class="invalid-feedback">
                                Por favor, ingrese un email válido.
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="contrasena" class="form-label">
                            <i class="ri-lock-line me-1"></i>Contraseña
                        </label>
                        <div class="input-wrapper">
                            <input type="password" 
                                   id="contrasena"
                                   name="contrasena" 
                                   class="form-control <?= $error && empty($_POST['contrasena'] ?? '') ? 'is-invalid' : '' ?>" 
                                   placeholder="Ingrese su contraseña"
                                   required />
                            <i class="ri-lock-line form-icon"></i>
                        </div>
                        <?php if ($error && empty($_POST['contrasena'] ?? '')): ?>
                            <div class="invalid-feedback">
                                Por favor, ingrese su contraseña.
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group">
                        <button class="btn-auth btn-primary-auth" type="submit">
                            <i class="ri-login-box-line me-2"></i>Iniciar Sesión
                        </button>
                    </div>
                </form>
                
                <div class="auth-divider">
                    <span>¿No tienes una cuenta?</span>
                </div>
                
                <div class="auth-links">
                    <a href="registro.php" class="auth-link">
                        <i class="ri-user-add-line me-2"></i>Registrarse
                    </a>
                </div>
                
                <div class="text-center mt-4">
                    <a href="../index.php" class="auth-back-link">
                        <i class="ri-arrow-left-line me-1"></i>Volver al inicio
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mejorar la validación del formulario
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('loginForm');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('contrasena');
            
            // Validación en tiempo real
            emailInput.addEventListener('blur', function() {
                if (this.value && !this.checkValidity()) {
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-invalid');
                }
            });
            
            passwordInput.addEventListener('blur', function() {
                if (this.value && !this.checkValidity()) {
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-invalid');
                }
            });
            
            // Validación al enviar
            form.addEventListener('submit', function(e) {
                let isValid = true;
                
                // Validar email
                if (!emailInput.value) {
                    emailInput.classList.add('is-invalid');
                    isValid = false;
                } else if (!emailInput.checkValidity()) {
                    emailInput.classList.add('is-invalid');
                    isValid = false;
                } else {
                    emailInput.classList.remove('is-invalid');
                }
                
                // Validar contraseña
                if (!passwordInput.value) {
                    passwordInput.classList.add('is-invalid');
                    isValid = false;
                } else {
                    passwordInput.classList.remove('is-invalid');
                }
                
                if (!isValid) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>
