<?php
/*Integrantes del Proyecto:
MERCEDES GUADALUPE - PR210566
DIEGO JOSUÉ - PA232942
DAVID ORELLANA - OG231911*/
?>
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
    <div class="wrapper">
        <h1>Regristro de Usuario</h1>
    <form action="includes/signup.inc.php" method="POST">
        
        <div class="input-box">
         <input type="text" name="firstName" placeholder="Nombres" required>
         <i class='bx bxs-user'></i>
        </div>

        <div class="input-box">
         <input type="text" name="lastName" placeholder="Apellidos" required>
         <i class='bx bxs-user'></i>
        </div>

        <div class="input-box">
         <input type="text" name="email" placeholder="Correo Electronico" required>
         <i class='bx bx-envelope'></i>
        </div>

        <div class="input-box">
         <input type="text" name="userLogin" placeholder="Usuario" required>
         <i class='bx bxs-user'></i>
        </div>

        
        <div class="input-box">
         <input type="password" name="userPassword" placeholder="Contrase&ntilde;a" required>
         <i class='bx bxs-lock' ></i>
        </div>

        <div class="input-box">
         <input type="password" name="passwordRepeat" placeholder="Repita Contrase&ntilde;a" required>
         <i class='bx bxs-lock' ></i>
        </div>

        <button type="submit" name="submit" class="btn">Registrar</button>
        <a href="./login.php" class="btn-regresar">Regresar</a>
                       
    </form>
<?php
if (isset($_GET["error"])) {
    if ($_GET["error"] == "emptyinput") {
        echo "<p>Por favor, llene todos los campos.</p>";
    }
    else if ($_GET["error"] == "invaliduid") {
        echo "<p>Por favor, elija un nombre de usuario valido.</p>";
    }
    else if ($_GET["error"] == "invalidemail") {
        echo "<p>Por favor, elija un correo electronico valido.</p>";
    }
    else if ($_GET["error"] == "passwordsdontmatch") {
        echo "<p>Las contraseñas no coinciden.</p>";
    }
    else if ($_GET["error"] == "stmtfailed") {
        echo "<p>Algo salio mal, intente de nuevo.</p>";
    }
    else if ($_GET["error"] == "usernametaken") {
        echo "<p>El nombre de usuario ya esta en uso.</p>";
    }
    else if ($_GET["error"] == "none") {
        echo "<p>Registro exitoso.</p>";
    }
}

?>

</body>
</html>