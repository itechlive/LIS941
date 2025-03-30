<?php
$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "budget";

try {
    $dsn = "mysql:host=$dbServername;dbname=$dbName;charset=utf8mb4";
    $pdo = new PDO($dsn, $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch transactions
    $stmt = $pdo->query("SELECT t.*, c.categoryName, c.type 
                         FROM transactionrecord t 
                         JOIN categories c ON t.categoryId = c.categoryId");
    $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Initialize totals
    $totalIncome = 0;
    $totalExpenses = 0;

    // Calculate totals
    foreach ($transactions as $transaction) {
        if ($transaction['type'] == 'income') {
            $totalIncome += $transaction['amount'];
        } else {
            $totalExpenses += $transaction['amount'];
        }
    }

    $totalBalance = $totalIncome - $totalExpenses;
} catch (PDOException $e) {
    error_log("Connection failed: " . $e->getMessage());
    exit("Connection failed.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reporte Financiero</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #black;
        }
        .total {
            font-weight: bold;
        }
        .print-button {
            margin-top: 20px;
        }
        .chart-container {
            width: 30%; 
            margin: auto;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Reporte Financiero</h1>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Categoria</th>
                <th>Descripcion</th>
                <th>Monto</th>
                <th>Tipo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transactions as $transaction): ?>
                <tr>
                    <td><?php echo htmlspecialchars($transaction['fecha']); ?></td>
                    <td><?php echo htmlspecialchars($transaction['categoryName']); ?></td>
                    <td><?php echo htmlspecialchars($transaction['description']); ?></td>
                    <td><?php echo htmlspecialchars($transaction['amount']); ?></td>
                    <td><?php echo htmlspecialchars($transaction['type']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="total">
                <td colspan="3">Total Income</td>
                <td colspan="2"><?php echo htmlspecialchars($totalIncome); ?></td>
            </tr>
            <tr class="total">
                <td colspan="3">Total Expenses</td>
                <td colspan="2"><?php echo htmlspecialchars($totalExpenses); ?></td>
            </tr>
            <tr class="total">
                <td colspan="3">Total Balance</td>
                <td colspan="2"><?php echo htmlspecialchars($totalBalance); ?></td>
            </tr>
        </tfoot>
    </table>
    <div class button>
    <button class="print-button" onclick="window.print()">Imprimir Reporte</button>

    <div class="chart-container">
        <canvas id="myPieChart"></canvas>
    </div>

    <script>
        var ctx = document.getElementById('myPieChart').getContext('2d');
        var myPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Entradas', 'Salidas'],
                datasets: [{
                    data: [<?php echo $totalIncome; ?>, <?php echo $totalExpenses; ?>],
                    backgroundColor: ['#36a2eb', '#ff6384']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': $' + tooltipItem.raw.toFixed(2);
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>