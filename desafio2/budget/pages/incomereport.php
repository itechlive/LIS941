<?php
/*Integrantes del Proyecto:
MERCEDES GUADALUPE - PR210566
DIEGO JOSUÉ - PA232942
DAVID ORELLANA - OG231911*/
session_start(); 
?>
<!DOCTYPE html>
<html lang="es">    
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ingresos</title>
    <link rel="stylesheet" href="./css/table.css">
    <style>
        table img {
            max-width: 100px; 
        }
    </style>
</head>
<body>
    <div class="container">
<?php
try {
    require_once __DIR__ . '/../includes/dbh.inc.php';

    if ($pdo) {
        echo "<!-- Database connection successful -->";
    } else {
        echo "<!-- Database connection failed -->";
    }

    $sql = "SELECT r.transactionId, c.categoryName, r.description, r.fecha AS date, r.amount, r.factura AS receipt 
            FROM transactionrecord r
            JOIN categories c ON r.categoryId = c.categoryId
            WHERE r.typeId = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    $totalIncome = 0;

    echo "<table border='1'>";
    echo "<tr><th>Transaccion</th><th>Categoria</th><th>Descripcion</th><th>Fecha</th><th>Monto</th><th>Recibo</th></tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $receiptPath = '/LIS941/desafio2/budget/uploads/' . htmlspecialchars($row['receipt']);
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['transactionId']) . "</td>";
        echo "<td>" . htmlspecialchars($row['categoryName']) . "</td>";
        echo "<td>" . htmlspecialchars($row['description']) . "</td>";
        echo "<td>" . htmlspecialchars($row['date']) . "</td>";
        echo "<td>" . htmlspecialchars($row['amount']) . "</td>";
        echo "<td><a href='#' onclick=\"window.open('$receiptPath', 'receiptWindow', 'width=400,height=500,scrollbars=yes'); return false;\">Ver Recibo</a></td>";
        echo "</tr>";

        $totalIncome += $row['amount'];
    }
    echo "<tr><td colspan='4' style='text-align:right; font-weight:bold;'>Total Entradas:</td><td colspan='2'>" . htmlspecialchars($totalIncome) . "</td></tr>";
    echo "</table>";
} catch (PDOException $e) {
    echo "<p>Error al cargar registros de ingresos</p>";
    error_log("Database error: " . $e->getMessage());
}
?>
    </div>

    <script>
        function openReceipt(url) {
            window.open(url, 'receiptWindow', 'width=400,height=500,scrollbars=yes');
            return false;
        }
    </script>
</body> 
</html>