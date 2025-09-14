<?php
header('Content-Type: application/json');

$host = "localhost";
$user = "root";
$pass = "";
$db   = "bd_sol";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    echo json_encode(["status"=>false,"message"=>"Error de conexión: ".$conn->connect_error]);
    exit;
}

$conn->set_charset("utf8mb4");
?>
