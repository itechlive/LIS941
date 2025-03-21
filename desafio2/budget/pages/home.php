<?php
session_start(); // Start the session

if (isset($_SESSION["useruid"])) { // Match the key set in loginUser
    echo "<h1>Bienvenido to the dashboard, " . $_SESSION["useruid"] . "!</h1>";
} else {
    header("location: login.php");
    exit();
}
?>
<!DOCTYPE html> 
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Estado Financiero Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/dashboard.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
<?php
    if (isset($_SESSION['error'])) {
        echo "<p style='color: red;'>{$_SESSION['error']}</p>";
        unset($_SESSION['error']); // Clear the error message
    }

    if (isset($_SESSION['success'])) {
        echo "<p style='color: green;'>{$_SESSION['success']}</p>";
        unset($_SESSION['success']); // Clear the success message
    }
    ?>
    <div class="wrapper">
       
    </div>
</body>
</html>