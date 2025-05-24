<?php

include("con_db.php");

if (isset($_POST['register'])){
    if (strlen($_POST['username']) >= 1 && strlen($_POST['email']) >= 1 && strlen($_POST['password']) >= 1) {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $fecha_reg = date("d/m/y");

        $consulta = "INSERT INTO accounts(username, password, email, fecha_reg) VALUES ('$username','$password','$email','$fecha_reg')";
        $resultado = mysqli_query($conex, $consulta);

        if ($resultado) {
            ?>
            <h3 class="ok">¡Te has registrado correctamente vuelve a login!</h3>
            <?php
        } else {
            ?>
            <h3 class="bad">¡Error al registrarse!</h3>
            <?php
        }
    } else {
        ?>
        <h3 class="bad">¡Por favor complete todos los campos!</h3>
        <?php
    }
}

?>