<?php

if (isset($_POST["submit"])) {
    // Recuperar y sanitizar la entrada
    $userLogin = trim($_POST["userLogin"]);
    $userPwd = $_POST["userPassword"]; // El hash de la contraseña ocurre en loginUser, así que no es necesario trim

    // Incluir archivos requeridos
    require_once 'dbh.inc.php';    // Archivo del conector de base de datos
    require_once 'functions.inc.php'; // Archivo de funciones

    // Chequear si la entrada está vacía
    if (emptyInputLogin($userLogin, $userPwd)) {
        header("location: ../login.php?error=emptyinput");
        exit();
    }

    // Intentar iniciar sesión del usuario
    loginUser($pdo, $userLogin, $userPwd);
} else {
    header("location: ../login.php");
    exit();
}
?>