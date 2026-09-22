<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require 'includes/db_config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Karfect</title>
    <link rel="stylesheet" href="<?php echo BASE_PATH; ?>assets/css/signup.css?v=<?php echo time(); ?>">
    <link rel="icon" type="image/x-icon" href="<?php echo BASE_PATH; ?>favicon.ico?v=<?php echo time(); ?>">
</head>
<body>
    <a href="<?php echo BASE_PATH; ?>index.php" class="back-link">← Back</a>

    <div class="main-login">
        <div class="container">
            <div class="login-box">
                <div class="logo">
                    <img src="<?php echo BASE_PATH; ?>assets/images/transparent_karfect.png" alt="Karfect Logo">
                </div>
                <p>Log in to your account</p>
                <div id="error-msg" class="error-msg"></div>

                <input type="email" placeholder="name@example.com" class="email-input" id="email-input">
                <div class="password-container">
                    <input type="password" placeholder="Enter Password" class="email-input" id="password-input">
                    <span class="eye-icon" id="toggle-password">👁️</span>
                </div>
                <button class="sign-in-btn" id="login-btn">Sign In with Email</button>

                <div class="divider">
                    <span>OR CONTINUE WITH</span>
                </div>
                <button class="google-btn" id="google-signin-btn">
                    <img src="https://www.google.com/favicon.ico" alt="Google Logo" class="google-logo">
                    Google
                </button>
                <p class="signup-link">Don't have an account? <a href="<?php echo BASE_PATH; ?>register.php">Sign Up</a></p>
            </div>
        </div>
    </div>

    <script>window.GOOGLE_CLIENT_ID = '<?php echo GOOGLE_CLIENT_ID; ?>'; window.BASE_PATH = '<?php echo BASE_PATH; ?>';</script>
    <script src="<?php echo BASE_PATH; ?>assets/js/script.js?v=<?php echo time(); ?>"></script>
</body>
</html>