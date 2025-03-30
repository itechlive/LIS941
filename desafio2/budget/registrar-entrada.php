<?php
// Incluir el archivo de conexión a la base de datos
require_once '../includes/dbh.inc.php';

// Si hay un mensaje de éxito o error desde el archivo de procesamiento, lo mostramos
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'success') {
        echo "<p class='success'>Entrada registrada con éxito.</p>";
    } elseif ($_GET['status'] == 'error') {
        echo "<p class='error'>Hubo un error al registrar la entrada. Intenta de nuevo.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Entrada</title>
    <link rel="stylesheet" href="../css/forms.css">
</head>
<body>
    <div class="container">
        <h2>Registrar Entrada</h2>
        <form action="../includes/entradas.inc.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="categoriesId">Categoría:</label>
                <select name="categoriesId" required>
                    <option value="">Seleccione una categoría</option>
                    <?php
                    // Seleccionar las categorías desde la base de datos
                    $sql = "SELECT categoriesId, categoryName FROM categories";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['categoriesId'] . "'>" . $row['categoryName'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No hay categorías disponibles</option>";
                    }

                    $conn->close();
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="eventDate">Fecha del Registro:</label>
                <input type="date" name="eventDate" required>
            </div>
            <div class="form-group">
                <label for="amount">Monto:</label>
                <input type="number" step="0.01" name="amount" required>
            </div>
            <div class="form-group">
                <label for="receiptsPic">Recibo:</label>
                <input type="file" name="receiptsPic" accept="image/*">
            </div>
            <div class="form-group">
                <input type="submit" value="Registrar Entrada">
            </div>
        </form>
    </div>
</body>
</html>
