<?php

if (isset($_POST["submit"])) {

$firstName = $_POST["firstName"];
$lastName = $_POST["lastName"]; 
$email = $_POST["email"];
$userLogin = $_POST["userLogin"];
$userPwd = $_POST["userPassword"];
$passwordRepeat = $_POST["passwordRepeat"];

require_once 'dbh.inc.php';
require_once 'functions.inc.php';

if (emptyInputSignup($firstName, $lastName, $email, $userLogin, $userPwd, $passwordRepeat) !== false) {
    header("location: ../signup.php?error=emptyinput");
    exit();
}

if (invalidUid($userLogin) !== false) {
    header("location: ../signup.php?error=invaliduid");
    exit();
}

if (invalidEmail($email) !== false) {
    header("location: ../signup.php?error=invalidemail");
    exit();
}

if (pwdMatch($userPwd, $passwordRepeat) !== false) {
    header("location: ../signup.php?error=passwordsdontmatch");
    exit();
}

if (uidExists($pdo, $userLogin, $email) !== false) {
    header("location: ../signup.php?error=usernametaken");
    exit();
}

createUser($pdo, $firstName, $lastName, $email, $userLogin, $userPwd);

}

else {
    header("location: ../signup.php");
    exit();
}
