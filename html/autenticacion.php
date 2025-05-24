<?php 
session_start();

//credenciales de acceso a la base de datos

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'login-php';

//conexion a la base de datos
$conexion = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    exit('Error al conectar a la base de datos' . mysqli_connect_error());
}

//verificar si se ha enviado el formulario
if (!isset($_POST['username'], $_POST['password'])) {


//si no hay datos muestra error y redireccionar a la pagina de login
header('Location: index.php?error=1');

}

$stmt = $conexion->prepare('SELECT id, password FROM accounts WHERE username = ?');
if ($stmt === false) {
    die('Error en prepare: ' . $conexion->error);
}

$stmt->bind_param('s', $_POST['username']);
$stmt->execute();

// Guardar resultados para poder usar num_rows
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Enlazar columnas a variables PHP
    $stmt->bind_result($id, $password);
    $stmt->fetch();

    if ($_POST['password'] === $password) { // Recomendado: usar password_verify
        session_regenerate_id();
        $_SESSION['loggedin'] = true;
        $_SESSION['name'] = $_POST['username'];
        $_SESSION['id'] = $id;
        header('Location: /coromotosuper/index.php');
        exit();
    } else {
        header('Location: /coromotosuper/html/login.html');
        exit();
    }
} else {
    header('Location: /coromotosuper/html/login.html');
    exit();
}

$stmt->close();
