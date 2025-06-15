<?php
// Encabezados para permitir el acceso CORS desde cualquier origen
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// --- INICIO DE LA CORRECCIÓN DE CORS ---
// El navegador envía una petición OPTIONS (preflight) para verificar los permisos
// antes de enviar peticiones como PUT o DELETE. Debemos responder con un '200 OK'.
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}
// --- FIN DE LA CORRECCIÓN DE CORS ---


// --- Conexión a la base de datos ---
$host = "localhost";
$dbname = "supercoromoto";
$user = "root";
$pass = "";
$port = "3306";
$conn = new mysqli($host, $user, $pass, $dbname, $port);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Error de conexión a la base de datos: " . $conn->connect_error]);
    exit;
}


// --- Enrutamiento simple ---
$method = $_SERVER['REQUEST_METHOD'];
$uri = explode("/", trim($_SERVER['REQUEST_URI'], "/"));
$endpoint = $uri[array_search("api.php", $uri) + 1] ?? null;
$id = $uri[array_search("api.php", $uri) + 2] ?? null;

if ($endpoint !== "usuarios") {
    http_response_code(404);
    echo json_encode(["error" => "Recurso no encontrado"]);
    exit;
}


// --- Lógica para cada método HTTP ---
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
        $success = $conn->query($sql);
        echo json_encode($success ? ["mensaje" => "Usuario creado"] : ["error" => $conn->error]);
        exit;

    case 'PUT':
        if (!$id) {
            echo json_encode(["error" => "ID requerido para actualizar"]);
            exit;
        }
        $data = json_decode(file_get_contents("php://input"), true);
        $nombre = $data['nombre'];
        $email = $data['email'];
        $rol = $data['rol'];
        $updateClave = '';
        if (!empty($data['clave'])) {
            $clave = password_hash($data['clave'], PASSWORD_DEFAULT);
            $updateClave = ", clave='$clave'";
        }
        $sql = "UPDATE usuarios SET nombre='$nombre', email='$email', rol='$rol' $updateClave WHERE id=$id";
        $success = $conn->query($sql);
        echo json_encode($success ? ["mensaje" => "Usuario actualizado"] : ["error" => $conn->error]);
        exit;

    case 'DELETE':
        if (!$id) {
            echo json_encode(["error" => "ID requerido para eliminar"]);
            exit;
        }
        $sql = "DELETE FROM usuarios WHERE id=$id";
        $success = $conn->query($sql);
        echo json_encode($success ? ["mensaje" => "Usuario eliminado"] : ["error" => $conn->error]);
        exit;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Método no soportado"]);
        exit;
}
?>