<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

$servername = "localhost";
$username = "root";
$password = "";
$database = "supercoromoto"; 

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die(json_encode(["error" => "Conexión fallida: " . $conn->connect_error]));
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $sql = "SELECT id, nombre, email, rol FROM usuarios";
        $result = $conn->query($sql);
        $usuarios = [];
        while ($row = $result->fetch_assoc()) {
            $usuarios[] = $row;
        }
        echo json_encode($usuarios);
        exit;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        $nombre = $data['nombre'];
        $email = $data['email'];
        $clave = password_hash($data['clave'], PASSWORD_DEFAULT);
        $rol = $data['rol'];

        $sql = "INSERT INTO usuarios (nombre, email, clave, rol) VALUES ('$nombre', '$email', '$clave', '$rol')";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["mensaje" => "Usuario creado"]);
            exit;
        } else {
            echo json_encode(["error" => $conn->error]);
            exit;
        }

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data['id'];
        $nombre = $data['nombre'];
        $email = $data['email'];
        $rol = $data['rol'];

        $updateClave = '';
        if (!empty($data['clave'])) {
            $clave = password_hash($data['clave'], PASSWORD_DEFAULT);
            $updateClave = ", clave='$clave'";
        }

        $sql = "UPDATE usuarios SET nombre='$nombre', email='$email', rol='$rol' $updateClave WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["mensaje" => "Usuario actualizado"]);
            exit;
        } else {
            echo json_encode(["error" => $conn->error]);
            exit;
        }

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data['id'];

        $sql = "DELETE FROM usuarios WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["mensaje" => "Usuario eliminado"]);
            exit;
        } else {
            echo json_encode(["error" => $conn->error]);
            exit;
        }

    default:
        echo json_encode(["error" => "Método no soportado"]);
        exit;
}