<?php
require_once '../includes/dbh.inc.php'; // Connector de la base de datos

$sql = "SELECT c.eventDate AS Fecha, 
               u.firstName AS Usuario, 
               u.lastName AS Apellido, 
               cat.categoryName AS Categoria, 
               c.amount AS Monto
        FROM cashflow c
        JOIN users u ON c.userId = u.userId
        JOIN categories cat ON c.categoriesId = cat.categoriesId
        JOIN transactionType tt ON c.transactionType = tt.typeId
        WHERE tt.typeName = 'Salidas'
        ORDER BY c.eventDate DESC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>Fecha</th><th>Usuario</th><th>Apellido</th><th>Categoria</th><th>Monto</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["Fecha"] . "</td><td>" . $row["Usuario"] . "</td><td>" . $row["Apellido"] . "</td><td>" . $row["Categoria"] . "</td><td>" . $row["Monto"] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "No records found";
}

$conn->close();
?>