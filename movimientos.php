<?php
include "db.php";

$action = $_GET["action"] ?? "";

// ====================
// AGREGAR MOVIMIENTO
// ====================
if ($action === "add" && $_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data["usuario_id"], $data["categoria_id"], $data["monto"], $data["fecha"])) {
        echo json_encode(["status" => "error", "message" => "Faltan datos"]);
        exit;
    }

    $usuario_id = intval($data["usuario_id"]);
    $categoria_id = intval($data["categoria_id"]);
    $monto = floatval($data["monto"]);
    $fecha = $conn->real_escape_string($data["fecha"]);
    $notas = $conn->real_escape_string($data["notas"] ?? "");

    $sql = "INSERT INTO movimientos (usuario_id, categoria_id, monto, fecha, notas)
            VALUES ($usuario_id, $categoria_id, $monto, '$fecha', '$notas')";

    if ($conn->query($sql)) {
        echo json_encode(["status" => "success", "message" => "Movimiento agregado"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
    }
    exit;
}

// ====================
// LISTAR MOVIMIENTOS POR USUARIO
// ====================
if ($action === "list" && isset($_GET["usuario_id"])) {
    $usuario_id = intval($_GET["usuario_id"]);

    $sql = "SELECT m.id, m.monto, m.fecha, m.notas, c.nombre AS categoria, c.tipo 
            FROM movimientos m
            JOIN categorias c ON m.categoria_id = c.id
            WHERE m.usuario_id = $usuario_id
            ORDER BY m.fecha DESC";

    $result = $conn->query($sql);

    $movimientos = [];
    while($row = $result->fetch_assoc()){
        $movimientos[] = $row;
    }

    echo json_encode($movimientos);
    exit;
}

echo json_encode(["status" => "error", "message" => "Acción inválida"]);
?>
