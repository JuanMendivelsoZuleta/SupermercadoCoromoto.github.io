<?php

include "conexion.php";
$id = intval($_GET['id']);

$conexion->query("DELETE FROM productos WHERE id_producto = $id");
header("Location: panelAdmin.php");
exit;
?>