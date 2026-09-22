<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is already logged in via session
if (!isset($_SESSION['user_id']) && isset($_COOKIE['user_login'])) {
    // Restore session from cookie
    $cookie_data = explode('|', $_COOKIE['user_login']);
    $_SESSION['user_id'] = $cookie_data[0];
    $_SESSION['user_name'] = $cookie_data[1];
}
?>