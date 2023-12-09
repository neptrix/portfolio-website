<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';


function sendVerificationEmail($email, $verificationCode) {
    $mail = new PHPMailer(true);
    try {
        // Configure email settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mixdoll27@gmail.com';
        $mail->Password = 'oabdtahmtmdzjpyf';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        // Set email content
        $mail->setFrom('mixdoll27@gmail.com');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Email Verification';
        $mail->Body = 'Please click the following link to verify your email: <a href="http://localhost/ben/verify.php?code=' . $verificationCode . '">Verify Email</a>';

        // Send the email
        $mail->send();
    } catch (Exception $e) {
        error_log("Email could not be sent. Error: {$mail->ErrorInfo}");
    }
}
function sendResetEmail($email, $token) {
    $mail = new PHPMailer(true);
    try {
        // Configure email settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mixdoll27@gmail.com';
        $mail->Password = 'oabdtahmtmdzjpyf';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        // Set email content
        $mail->setFrom('mixdoll27@gmail.com');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset';
        $mail->Body = 'Please click the following link to reset your accounts password: <a href="http://localhost/ben/reset-password.php?token=' . $token . '">Reset Password</a>';

        // Send the email
        $mail->send();
    } catch (Exception $e) {
        error_log("Email could not be sent. Error: {$mail->ErrorInfo}");
    }
}
?>
