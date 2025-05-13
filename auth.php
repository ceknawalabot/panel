<?php
session_start();

// Hardcoded user credentials for demo
$valid_username = 'admin';
$valid_password = 'password';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === $valid_username && $password === $valid_password) {
        // Set session
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header('Location: dashboard.php');
        exit;
    } else {
        // Invalid login
        $_SESSION['error'] = 'Invalid username or password';
        header('Location: index.php');
        exit;
    }
} elseif (isset($_GET['action']) && $_GET['action'] === 'logout') {
    // Logout action
    session_destroy();
    header('Location: index.php');
    exit;
} else {
    // Invalid access
    header('Location: index.php');
    exit;
}
