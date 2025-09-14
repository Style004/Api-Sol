<?php
header('Content-Type: application/json');
include "../config/db.php";

$action = $_GET["action"] ?? "";

// ====================
// VER PERFIL
// ====================
if ($action === "ver" && isset($_GET["usuario_id"])) {
    $usuario_id = intval($_GET["usuario_id"]);
    $sql = "SELECT u.nombre, u.apellido, u.email, u.telefono, p.direccion 
            FROM usuarios u 
            LEFT JOIN perfil p ON u.id = p.usuario_id
            WHERE u.id = $usuario_id";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $perfil = $result->fetch_assoc();
        echo json_encode(["status"=>true,"perfil"=>$perfil]);
    } else {
        echo json_encode(["status"=>false,"message"=>"Usuario no encontrado"]);
    }
    exit;
}

// ====================
// EDITAR PERFIL
// ====================
if ($action === "editar" && $_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    if(!isset($data["usuario_id"])) {
        echo json_encode(["status"=>false,"message"=>"Falta usuario_id"]);
        exit;
    }

    $usuario_id = intval($data["usuario_id"]);
    $telefono = $conn->real_escape_string($data["telefono"] ?? "");
    $direccion = $conn->real_escape_string($data["direccion"] ?? "");

    $sql = "INSERT INTO perfil (usuario_id, telefono, direccion) 
            VALUES ($usuario_id, '$telefono', '$direccion') 
            ON DUPLICATE KEY UPDATE telefono='$telefono', direccion='$direccion'";

    if($conn->query($sql)){
        echo json_encode(["status"=>true,"message"=>"Perfil actualizado"]);
    } else {
        echo json_encode(["status"=>false,"message"=>"Error: ".$conn->error]);
    }
    exit;
}

echo json_encode(["status"=>false,"message"=>"Acción inválida"]);
?>
