<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$_SESSION = [];
session_destroy();

if (isset($_COOKIE['user_login'])) {
    setcookie('user_login', '', time() - 3600, '/karfect/');
}

header('Location: /karfect/login.php');
exit;
?>