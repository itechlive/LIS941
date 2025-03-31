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
        <h2>Registrar Entrada</h2>
        <form action="../includes/record.inc.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="categoryId">Categoría:</label>
                <select name="categoryId" required>
                    <option value="">Seleccione una categoría</option>
                    <?php
                    try {
                        require_once '../includes/dbh.inc.php'; // Carga $pdo
                        $sql = "SELECT categoryId, categoryName FROM categories WHERE type = 'income'";
                        $stmt = $pdo->query($sql); // Usa PDO
                        if ($stmt->rowCount() > 0) {
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='" . $row['categoryId'] . "'>" . $row['categoryName'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>No hay categorías disponibles</option>";
                        }
                    } catch (Exception $e) {
                        echo "<option value=''>Error: " . $e->getMessage() . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="description">Descripción de la Transacción:</label>
                <input type="text" name="description">
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
                <input type="file" name="factura" accept="image/*">
            </div>
            <input type="hidden" name="typeId" value="1">
            <div class="form-group">
                <input type="submit" value="Registrar Entrada">
            </div>
        </form>
    </div>
</body>
</html>