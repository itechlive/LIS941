<!DOCTYPE html>
<html lang="=es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Estado Financiero Login</title>
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <!--Integrantes del Proyecto:
    MERCEDES GUADALUPE - PR210566
    DIEGO JOSUÉ - PA232942
    DAVID ORELLANA - OG231911-->
    <div class="wrapper">
        <h1>Inicio de Sesi&oacute;n</h1>
    <form action="includes/login.inc.php" method="POST">
        
        <div class="input-box">
         <input type="text" name="userLogin" placeholder="Usuario o Email" required>
         <i class='bx bxs-user'></i>
        </div>
        
        <div class="input-box">
         <input type="password" name="userPassword" placeholder="Contrase&ntilde;a" required>
         <i class='bx bxs-lock' ></i>
        </div>

        <button type="submit" name="submit" class="btn">Ingresar</button>
        
        <p>¿No tienes una cuenta? <a href="signup.php">Registrate</a></p>
        
    </form>

    <?php
    if (isset($_GET["error"])) {
        if ($_GET["error"] == "emptyinput") {
            echo "<p>Por favor, llene todos los campos.</p>";
        }
        else if ($_GET["error"] == "wronglogin") {
            echo "<p>Usuario o Contrase&ntilde;a incorrectos.</p>";
        }
    }
    ?>
</body>
</html>