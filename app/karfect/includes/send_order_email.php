<?php
// Manually include PHP Mailer files (path updated to karfect/vendor/phpmailer)
require '../vendor/phpmailer/src/Exception.php';
require '../vendor/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/src/SMTP.php';
require 'email_template.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendOrderEmail($order_details, $user_details, $order_items) {
    $mail = new PHPMailer(true);

    try {
        // Server settings (updated with provided Gmail credentials)
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'tripgo.official@gmail.com'; // Provided Gmail address
        $mail->Password = 'qqaq bylf uqui ouxg'; // Provided app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('support@karfect.com', 'Karfect');
        $mail->addAddress($user_details['email'], $user_details['name']); // Updated to use 'name'
        $mail->addReplyTo('support@karfect.com', 'Karfect Support');

        // Content
        $mail->isHTML(true);
        $mail->Subject = "Your Order Confirmation - Order #{$order_details['order_id']}";
        $mail->Body = getEmailTemplate($order_details, $user_details, $order_items);
        $mail->AltBody = "Order #{$order_details['order_id']} has been placed successfully. Please check your account for details.";

        $mail->send();
        return ['status' => 'success', 'message' => 'Email sent successfully'];
    } catch (Exception $e) {
        error_log("Email sending failed: {$mail->ErrorInfo}");
        return ['status' => 'error', 'message' => 'Failed to send email: ' . $mail->ErrorInfo];
    }
}
?>