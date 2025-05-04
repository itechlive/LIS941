<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cuponera";

try {
    // Crear conexión PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Configurar el modo de error PDO a excepción
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Opcional: Configurar el juego de caracteres a UTF-8
    $conn->exec("SET NAMES utf8");
} catch(PDOException $e) {
    die("Conexión fallida: " . $e->getMessage());
}
?>