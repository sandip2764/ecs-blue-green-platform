<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require '../../vendor/phpmailer/src/Exception.php';
require '../../vendor/phpmailer/src/PHPMailer.php';
require '../../vendor/phpmailer/src/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../includes/db_config.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid email format']);
            exit;
        }

        // Check if email already exists
        $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $emailExists = $stmt->fetchColumn();

        if ($emailExists > 0) {
            echo json_encode(['status' => 'error', 'message' => 'Email already registered']);
            exit;
        }

        $otp = rand(1000, 9999);
        $_SESSION['otp'] = $otp;
        $_SESSION['email'] = $email;

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'tripgo.official@gmail.com';
        $mail->Password = 'qqaq bylf uqui ouxg';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('karfect.service@gmail.com', 'Karfect');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code';
        $mail->Body = "Your OTP is: <b>$otp</b>. It expires in 5 minutes.";

        $mail->send();
        echo json_encode(['status' => 'success', 'message' => 'OTP sent to your email']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to send OTP: ' . $e->getMessage()]);
}
?>