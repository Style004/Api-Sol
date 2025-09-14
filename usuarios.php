<?php
include "db.php";

$action = $_GET["action"] ?? "";

// ====================
// REGISTRO
// ====================
if ($action === "register" && $_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data["nombre"], $data["apellido"], $data["email"], $data["password"])) {
        echo json_encode(["status" => "error", "message" => "Faltan datos"]);
        exit;
    }

    $nombre = $conn->real_escape_string($data["nombre"]);
    $apellido = $conn->real_escape_string($data["apellido"]);
    $email = $conn->real_escape_string($data["email"]);
    $password = password_hash($data["password"], PASSWORD_BCRYPT);

    $sql = "INSERT INTO usuarios (nombre, apellido, email, password) 
            VALUES ('$nombre', '$apellido', '$email', '$password')";

    if ($conn->query($sql)) {
        echo json_encode(["status" => "success", "message" => "Usuario registrado"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
    }
    exit;
}

// ====================
// LOGIN
// ====================
if ($action === "login" && $_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data["email"], $data["password"])) {
        echo json_encode(["status" => "error", "message" => "Faltan datos"]);
        exit;
    }

    $email = $conn->real_escape_string($data["email"]);
    $password = $data["password"];

    $sql = "SELECT * FROM usuarios WHERE email='$email' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user["password"])) {
            echo json_encode([
                "status" => "success",
                "message" => "Login correcto",
                "usuario" => [
                    "id" => $user["id"],
                    "nombre" => $user["nombre"],
                    "apellido" => $user["apellido"],
                    "email" => $user["email"]
                ]
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "Contraseña incorrecta"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Usuario no encontrado"]);
    }
    exit;
}

// ====================
// LISTAR USUARIOS
// ====================
if ($action === "list") {
    $sql = "SELECT id, nombre, apellido, email, telefono FROM usuarios";
    $result = $conn->query($sql);

    $usuarios = [];
    while($row = $result->fetch_assoc()){
        $usuarios[] = $row;
    }

    echo json_encode($usuarios);
    exit;
}

echo json_encode(["status" => "error", "message" => "Acción inválida"]);
?>
