<?php
/*Integrantes del Proyecto:
MERCEDES GUADALUPE - PR210566
DIEGO JOSUÉ - PA232942
DAVID ORELLANA - OG231911*/

session_start();
// Destroy the session
session_unset();
session_destroy();

// Redirect to the login page
header("Location: ./login.php");
exit();
?>