<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Entrada</title>
    <link rel="stylesheet" href="./css/general.css">
</head>
<body>
    <div class="container">
        <h2>Registrar Entrada</h2>
        <form action="/budget/includes/record.inc.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="categoryId">Categoría:</label>
                <select name="categoryId" required>
                    <option value="">Seleccione una categoría</option>
                    <?php
                    try {
                        require_once __DIR__ . '/../includes/dbh.inc.php'; // Database handler

                        // Check if the connection is successful
                        if ($pdo) {
                            echo "<!-- Database connection successful -->";
                        } else {
                            echo "<!-- Database connection failed -->";
                        }

                        // Select only income categories from the database
                        $sql = "SELECT categoryId, categoryName FROM categories WHERE type = 'income'";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . htmlspecialchars($row['categoryId']) . "'>" . 
                                 htmlspecialchars($row['categoryName']) . "</option>";
                        }
                    } catch (PDOException $e) {
                        echo "<option value=''>Error al cargar categorías</option>";
                        error_log("Database error: " . $e->getMessage());
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="description">Descripticion del la Transaccion:</label>
                <input type="text" name="description" required>
            </div>
            <div class="form-group">
                <label for="fecha">Fecha del Registro:</label>
                <input type="date" name="fecha" required>
            </div>
            <div class="form-group">
                <label for="amount">Monto:</label>
                <input type="number" step="0.01" name="amount" required>
            </div>
            <div class="form-group">
            <label for="factura">Recibo:</label>
            <input type="file" name="factura" accept="image/*" required>
            </div>
            <input type="hidden" name="typeId" value="1">
            <div class="form-group">
                <input type="submit" value="Registrar Entrada">
            </div>
        </form>
    </div>
</body>
</html>