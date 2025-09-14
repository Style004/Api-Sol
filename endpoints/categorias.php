<?php
header('Content-Type: application/json');
include "../config/db.php";

$sql = "SELECT * FROM categorias ORDER BY tipo, nombre";
$result = $conn->query($sql);

if(!$result){
    echo json_encode(["status"=>false,"message"=>"Error en consulta: ".$conn->error]);
    exit;
}

$categorias = [];
while($row = $result->fetch_assoc()){
    $categorias[] = $row;
}

echo json_encode([
    "status" => true,
    "categorias" => $categorias
]);
?>
