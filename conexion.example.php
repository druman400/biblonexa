<?php
// conexion.example.php
// Copia este archivo como "conexion.php" y ajusta tus credenciales de MySQL.
$conn = new mysqli("localhost", "root", "", "biblonexa");
if ($conn->connect_error) die("Error de conexión: " . $conn->connect_error);
$conn->set_charset("utf8mb4");
?>
