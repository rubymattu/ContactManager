<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('database.php');

$user_name = filter_input(INPUT_POST, 'user_name');
$password = filter_input(INPUT_POST, 'password');

if (!$user_name || !$password) {
    $_SESSION['login_error'] = 'Please enter both username and password.';
    header('Location: login_form.php');
    exit;
}

// Check lockout
if (isset($_SESSION['lockout_time']) && time() < $_SESSION['lockout_time']) {
    $_SESSION['login_error'] = 'Too many failed attempts. Try again in 1 minute.';
    header('Location: login_form.php');
    exit;
}

// Case-insensitive username search
$query = 'SELECT * FROM registrations WHERE userName = :userName';
$statement = $db->prepare($query);
$statement->bindValue(':userName', $user_name);
$statement->execute();
$user = $statement->fetch();
$statement->closeCursor();

if ($user) {
    // Verify password
    if (password_verify($password, $user['password'])) {
        // Success
        $_SESSION['isLoggedIn'] = true;
        $_SESSION['userName'] = $user['userName'];

        // Reset login attempts
        unset($_SESSION['failed_attempts']);
        unset($_SESSION['lockout_time']);
        unset($_SESSION['login_error']);

        header('Location: login_confirmation.php');
        exit;
    } else {
        $_SESSION['login_error'] = 'Incorrect password.';
    }
} else {
    $_SESSION['login_error'] = 'Username not found.';
}

// Handle failed attempts
$_SESSION['failed_attempts'] = ($_SESSION['failed_attempts'] ?? 0) + 1;

if ($_SESSION['failed_attempts'] >= 3) {
    $_SESSION['lockout_time'] = time() + 60; // 1 minute
    $_SESSION['login_error'] = 'Too many failed attempts. You are locked out for 1 minute.';
}

header('Location: login_form.php');
exit;
?>
