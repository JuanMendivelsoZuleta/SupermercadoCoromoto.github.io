<?php
session_start();
$total = array_sum($_SESSION['carrito'] ?? []);
echo json_encode(["total" => $total]);
