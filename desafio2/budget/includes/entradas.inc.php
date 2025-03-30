<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Incluir la conexión a la base de datos
    require_once 'dbh.inc.php';

    // Obtener los datos del formulario
    $categoriesId = $_POST['categoriesId'];
    $eventDate = $_POST['eventDate'];
    $amount = $_POST['amount'];

    // Subir el archivo del recibo (si se ha subido)
    if (isset($_FILES['receiptsPic']) && $_FILES['receiptsPic']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "../uploads/"; // Directorio donde se guardarán los archivos
        $fileName = basename($_FILES['receiptsPic']['name']);
        $targetFile = $targetDir . $fileName;

        // Verificar que el archivo es una imagen
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        if (in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            if (move_uploaded_file($_FILES['receiptsPic']['tmp_name'], $targetFile)) {
                $receiptPath = $targetFile; // Guardamos la ruta del archivo
            } else {
                echo "Error al subir el archivo.";
                exit();
            }
        } else {
            echo "Solo se permiten imágenes (JPG, PNG, JPEG, GIF).";
            exit();
        }
    } else {
        $receiptPath = NULL; // Si no hay archivo, dejamos el campo en NULL
    }

    // Insertar los datos en la base de datos
    $sql = "INSERT INTO entradas (categoriesId, eventDate, amount, receiptsPic) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $categoriesId, $eventDate, $amount, $receiptPath);

    if ($stmt->execute()) {
        echo "Entrada registrada con éxito.";
    } else {
        echo "Error al registrar la entrada: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
