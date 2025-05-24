<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/coromotosuper/css/register.css">
    <title>Formulario Registro</title> 
</head>
<body>
    <header>
        <a href="/coromotosuper/index.php">Volver al inicio </a>
    </header>
    <section class="form-register">
        <form action="" method="post">
        <h4>Formulario Registro</h4>
        <input class="controls" type="text" name="username" id="username" placeholder="Ingrese su Nombre de Usuario">
        <input class="controls" type="email" name="email" id="correo" placeholder="Ingrese su Correo">
        <input class="controls" type="password" name="password" id="password" placeholder="Ingrese su Contraseña">
        <p> Estoy de acuerdo con <a href="#">Terminos y condiciones </a></p>
        <input class="botons" type="submit" name="register" value="Registrar">
        <p><a href="/coromotosuper/html/login.html"> ¿Ya tengo cuenta? </a></p>
        </form>

        <?php 
        include("registrar.php");
        ?>
    </section>
</body>
</html>