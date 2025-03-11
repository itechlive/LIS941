<?php

// Check if signup fields are empty
function emptyInputSignup($firstName, $lastName, $email, $userLogin, $userPwd, $passwordRepeat) {
    return empty($firstName) || empty($lastName) || empty($email) || empty($userLogin) || empty($userPwd) || empty($passwordRepeat);
}

// Check if username is valid
function invalidUid($userLogin) {
    return !preg_match("/^[a-zA-Z0-9]*$/", $userLogin);
}

// Check if email is valid
function invalidEmail($email) {
    return !filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Check if passwords match
function pwdMatch($userPwd, $passwordRepeat) {
    return $userPwd !== $passwordRepeat;
}

// Check if user already exists
function uidExists($pdo, $userLogin, $email) {
    try {
        $sql = "SELECT * FROM users WHERE userLogin = ? OR email = ?"; // Select all fields
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userLogin, $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: false; // Return row or false
    } catch (Exception $e) {
        error_log("uidExists error: " . $e->getMessage()); // Log error
        return false;
    }
}

// Create user
function createUser($pdo, $firstName, $lastName, $email, $userLogin, $userPwd) {
    try {
        $sql = "INSERT INTO users (firstName, lastName, email, userLogin, userPwd) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $hashedPwd = password_hash($userPwd, PASSWORD_DEFAULT);
        $stmt->execute([$firstName, $lastName, $email, $userLogin, $hashedPwd]);
        
        header("location: ../signup.php?error=none");
        exit();
    } catch (Exception $e) {
        error_log("createUser error: " . $e->getMessage()); // Log error
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }
}

// Check if login fields are empty
function emptyInputLogin($userLogin, $userPwd) {
    return empty($userLogin) || empty($userPwd);
}

// Login user
function loginUser($pdo, $userLogin, $userPwd) {
    $uidExists = uidExists($pdo, $userLogin, $userLogin); // Check if user exists
    
    if ($uidExists === false) {
        header("location: ../login.php?error=wronglogin");
        exit();
    }
    
    $pwdHashed = $uidExists["userPwd"];
    $checkPwd = password_verify($userPwd, $pwdHashed);
    
    if ($checkPwd === false) {
        header("location: ../login.php?error=wronglogin");
        exit();
    }
    
    session_start();
    $_SESSION["userid"] = $uidExists["userId"];
    $_SESSION["useruid"] = $uidExists["userLogin"];
    header("location: ../dashboard.php");
    exit();
}

?>