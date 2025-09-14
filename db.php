<?php
$host = "localhost";
$user = "root";  // usuario XAMPP
$pass = "";      // contraseña (vacía si no configuraste)
$db   = "bd_sol";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
