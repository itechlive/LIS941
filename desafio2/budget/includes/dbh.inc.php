<?php
$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "budget";

try {
    $dsn = "mysql:host=$dbServername;dbname=$dbName;charset=utf8mb4";
    $pdo = new PDO($dsn, $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    error_log("Connection failed: " . $e->getMessage());
    exit("Connection failed.");
}
?>