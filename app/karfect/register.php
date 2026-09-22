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
    <title>Register - Karfect</title>
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
                <h2 id="step-title">Create your account</h2>
                <div id="error-msg" class="error-msg"></div>

                <!-- Email Step -->
                <div id="email-step">
                    <input type="text" placeholder="Full Name" class="email-input" id="name-input">
                    <input type="email" placeholder="name@example.com" class="email-input" id="email-input">
                    <div class="password-container">
                        <input type="password" placeholder="Create Password" class="email-input" id="password-input">
                        <span class="eye-icon" id="toggle-password"></span>
                    </div>
                    <button class="sign-in-btn" id="register-btn">Sign Up with Email</button>
                </div>

                <!-- OTP Step -->
                <div id="otp-step" class="hidden">
                    <div class="otp-container">
                        <input type="text" class="otp-input" maxlength="1">
                        <input type="text" class="otp-input" maxlength="1">
                        <input type="text" class="otp-input" maxlength="1">
                        <input type="text" class="otp-input" maxlength="1">
                    </div>
                    <button class="sign-in-btn" id="verify-otp-btn">Verify OTP</button>
                    <p>Resend OTP in <span id="timer">30s</span> <a href="#" id="resend-otp-btn" class="disabled">Resend OTP</a></p>
                </div>

                <!-- Password Step -->
                <div id="password-step" class="hidden">
                    <input type="text" placeholder="Full Name" class="email-input" id="name-input" value="">
                    <div class="password-container">
                        <input type="password" placeholder="Create Password" class="email-input" id="password-input">
                        <span class="eye-icon" id="toggle-password"></span>
                    </div>
                    <div class="password-container">
                        <input type="password" placeholder="Confirm Password" class="email-input" id="confirm-password-input">
                        <span class="eye-icon" id="toggle-confirm-password"></span>
                    </div>
                    <button class="sign-in-btn" id="complete-signup-btn">Complete Sign Up</button>
                </div>

                <div class="divider">
                    <span>OR CONTINUE WITH</span>
                </div>
                <button class="google-btn" id="google-signin-btn">
                    <img src="https://www.google.com/favicon.ico" alt="Google Logo" class="google-logo">
                    Google
                </button>
                <p class="signup-link">Already have an account? <a href="<?php echo BASE_PATH; ?>login.php">Log In</a></p>
            </div>
        </div>
    </div>

    <script>window.GOOGLE_CLIENT_ID = '<?php echo GOOGLE_CLIENT_ID; ?>'; window.BASE_PATH = '<?php echo BASE_PATH; ?>';</script>
    <script src="<?php echo BASE_PATH; ?>assets/js/script.js?v=<?php echo time(); ?>"></script>
</body>
</html>