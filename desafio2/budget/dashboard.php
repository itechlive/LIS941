<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="./css/general.css">
</head>
<body>
    <div class="sidebar">
        <h2>Dashboard</h2>
        <ul>
            <li><a href="?page=home">Home</a></li>    
            <li><a href="/LIS941/desafio2/budget/pages/income.php">Registrar Entrada</a></li>
            <li><a href="?page=expenses">Registrar Salida</a></li>
            <li><a href="?page=incomereport">Ver Entradas</a></li>
            <li><a href="?page=expensesreport">Ver Salidas</a></li>
            <li><a href="?page=balance">Mostrar Balance</a></li>
            <li><a href="?page=logout">Cerrar Sesión</a></li>
        </ul>
    </div>
    <div class="content">
        <?php
        $page = isset($_GET['page']) ? $_GET['page'] : 'home';
        $allowed_pages = ['home', 'income', 'expenses', 'incomereport', 'expensesreport', 'balance', 'logout'];
        if (!in_array($page, $allowed_pages)) {
            $page = 'home';
        }
        $content_file = "pages/{$page}.php";
        if (file_exists($content_file)) {
            include $content_file;
        } else {
            echo "<h1>Page not found</h1>";
            error_log("Page not found: " . $content_file);
        }
        ?>
    </div>
</body> 
</html>