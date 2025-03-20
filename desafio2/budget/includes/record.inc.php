<?php
session_start();
require_once 'dbh.inc.php'; // PDO database connector

// Check if user is logged in
if (!isset($_SESSION["userid"])) {
    header("Location: /index.html");
    exit();
}

// Check if form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../index.html");
    exit();
}

try {
    $userId = $_SESSION["userid"];
    $categoryId = $_POST['categoryId'] ?? '';
    $typeId = $_POST['typeId'] ?? '';
    $fecha = $_POST['fecha'] ?? '';
    $amount = $_POST['amount'] ?? '';
    $description = $_POST['description'] ?? '';
    $factura = null; 

    // Validate input
    if (empty($categoryId) || empty($fecha) || empty($amount)) {
        die("Todos los campos requeridos deben ser completados.");
    }

    if (!is_numeric($amount) || $amount <= 0) {
        die("El monto debe ser un número positivo.");
    }

    // Calculate total income and total expenses
    $sqlIncome = "SELECT SUM(amount) as totalIncome FROM transactionrecord WHERE userId = :userId AND typeId = 1";
    $stmtIncome = $pdo->prepare($sqlIncome);
    $stmtIncome->execute([':userId' => $userId]);
    $totalIncome = $stmtIncome->fetch(PDO::FETCH_ASSOC)['totalIncome'] ?? 0;

    $sqlExpense = "SELECT SUM(amount) as totalExpense FROM transactionrecord WHERE userId = :userId AND typeId = 2";
    $stmtExpense = $pdo->prepare($sqlExpense);
    $stmtExpense->execute([':userId' => $userId]);
    $totalExpense = $stmtExpense->fetch(PDO::FETCH_ASSOC)['totalExpense'] ?? 0;

    // Check if the new expense exceeds the available funds
    if ($typeId == 2 && ($totalExpense + $amount) > $totalIncome) {
        die("No hay suficientes fondos para esta transacción.");
    }

    // Handle file upload if present
    if (isset($_FILES['factura']) && $_FILES['factura']['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxSize = 5 * 1024 * 1024; // 5MB
        $uploadDir = __DIR__ . '/../img/'; 
        $fileName = uniqid() . '_' . basename($_FILES['factura']['name']); // Unique filename
        $uploadFile = $uploadDir . $fileName;

        // Ensure the upload directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Create directory if it doesn’t exist
        }

        if (in_array($_FILES['factura']['type'], $allowedTypes) && 
            $_FILES['factura']['size'] <= $maxSize) {
            if (move_uploaded_file($_FILES['factura']['tmp_name'], $uploadFile)) {
                $factura = $uploadFile; // Store the full path in $factura
            } else {
                die("Error al subir el archivo. Verifica permisos o existencia del directorio.");
            }
        } else {
            die("Archivo no válido. Solo se permiten imágenes JPEG, PNG o GIF de hasta 5MB.");
        }
    }

    // Insert data into transactionrecord table using prepared statement
    $sql = "INSERT INTO transactionrecord (userId, categoryId, description, typeId, fecha, amount, factura)
            VALUES (:userId, :categoryId, :description, :typeId, :fecha, :amount, :factura)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':userId' => (int)$userId,
        ':categoryId' => (int)$categoryId,
        ':typeId' => $typeId,
        ':description' => $description,
        ':fecha' => $fecha,
        ':amount' => (float)$amount,
        ':factura' => $factura
    ]);

    echo "Entrada registrada exitosamente.";
    
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    echo "Error al registrar la entrada. Detalle: " . $e->getMessage();
} catch (Exception $e) {
    error_log("General error: " . $e->getMessage());
    echo "Error.";
}
?>