<?php
session_start();
require_once 'dbh.inc.php'; // PDO database connector

// Check if user is logged in
if (!isset($_SESSION["userid"])) {
    header("Location: ../login.php");
    exit();
}

// Check if form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../dashboard.php");
    exit();
}

try {
    $userId = $_SESSION["userid"];
    $categoryId = $_POST['categoryId'] ?? '';
    $typeId = $_POST['typeId'] ?? 1; // 1 para entradas, 2 para salidas
    $fecha = $_POST['fecha'] ?? '';
    $amount = $_POST['amount'] ?? '';
    $description = $_POST['description'] ?? null; // Puede ser NULL
    $factura = null;

    // Determinar la página de redirección según el tipo de transacción
    $redirectPage = ($typeId == 1) ? '../pages/income.php' : '../pages/expenses.php';

    // Validate input
    if (empty($categoryId) || empty($fecha) || empty($amount)) {
        $_SESSION['error'] = "Todos los campos requeridos deben ser completados.";
        header("Location: $redirectPage");
        exit();
    }

    if (!is_numeric($amount) || $amount <= 0) {
        $_SESSION['error'] = "El monto debe ser un número positivo.";
        header("Location: $redirectPage");
        exit();
    }

    // Handle file upload if present
    if (isset($_FILES['factura']) && $_FILES['factura']['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxSize = 5 * 1024 * 1024; // 5MB
        $uploadDir = __DIR__ . '/../uploads/';
        $fileName = uniqid() . '_' . basename($_FILES['factura']['name']);
        $uploadFile = $uploadDir . $fileName;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (in_array($_FILES['factura']['type'], $allowedTypes) && 
            $_FILES['factura']['size'] <= $maxSize) {
            if (move_uploaded_file($_FILES['factura']['tmp_name'], $uploadFile)) {
                $factura = $fileName; // Guardar solo el nombre del archivo
            } else {
                $_SESSION['error'] = "Error al subir el archivo. Verifica permisos.";
                header("Location: $redirectPage");
                exit();
            }
        } else {
            $_SESSION['error'] = "Archivo no válido. Solo imágenes JPEG, PNG o GIF de hasta 5MB.";
            header("Location: $redirectPage");
            exit();
        }
    }

    // Insert data into transactionrecord table
    $sql = "INSERT INTO transactionrecord (userId, typeId, categoryId, description, fecha, amount, factura)
            VALUES (:userId, :typeId, :categoryId, :description, :fecha, :amount, :factura)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':userId' => (int)$userId,
        ':typeId' => (int)$typeId,
        ':categoryId' => (int)$categoryId,
        ':description' => $description !== '' ? $description : null,
        ':fecha' => $fecha,
        ':amount' => (float)$amount,
        ':factura' => $factura
    ]);

    // Definir el mensaje de éxito según el tipo de transacción
    $successMessage = ($typeId == 1) ? "Entrada registrada exitosamente." : "Salida registrada exitosamente.";
    $_SESSION['success'] = $successMessage;
    header("Location: ../dashboard.php");
    exit();
    
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $_SESSION['error'] = "Error al registrar los datos. Detalle: " . $e->getMessage();
    header("Location: $redirectPage");
    exit();
} catch (Exception $e) {
    error_log("General error: " . $e->getMessage());
    $_SESSION['error'] = "Error inesperado.";
    header("Location: $redirectPage");
    exit();
}
?>