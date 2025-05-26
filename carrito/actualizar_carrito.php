<?php
session_start();

if (isset($_POST['id']) && isset($_POST['cantidad'])) {
  $id = $_POST['id'];
  $cantidad = max(1, intval($_POST['cantidad'])); // nunca menor a 1

  $_SESSION['carrito'][$id] = $cantidad;
}

header("Location: carrito.php");
exit();
