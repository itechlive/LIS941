<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Entrada</title>
    <link rel="stylesheet" href="../css/forms.css">
</head>
<body>
    <!--Integrantes del Proyecto:
    MERCEDES GUADALUPE - PR210566
    DIEGO JOSUÉ - PA232942
    DAVID ORELLANA - OG231911-->
    <div class="container">
        <h2>Registrar Salidas</h2>
        <form action="../includes/salidas.inc.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="categoriesId">Categoría:</label>
                <select name="categoriesId" required>
                    <option value="">Seleccione una categoría</option>
                    <?php
                    require_once '../includes/dbh.inc.php'; // Connector de la base de datos

                    // Selecionar categorías de la base de datos
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
                <label for="eventDate">Fecha del Regristro:</label>
                <input type="date" name="eventDate" required>
            </div>
            <div class="form-group">
                <label for="amount">Monto:</label>
                <input type="number" step="0.01" name="amount" required>
            </div>
            
            <div class="form-group">
                <input type="submit" value="Registrar Salida">
            </div>
        </form>
    </div>
</body>
</html>