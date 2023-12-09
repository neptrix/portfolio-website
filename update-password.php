<?php
// Start session and connect to database
session_start();
require_once('db/conn.php');

// Check if token and password form are submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['g-recaptcha-response'])) {
        $secretKey = "6LfYAzwkAAAAAAq4A6M953A6x9qrota1J1b7IC_a";
        $captchaResponse = $_POST['g-recaptcha-response'];
        $remoteIp = $_SERVER['REMOTE_ADDR'];


        // Verify the captcha response
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$captchaResponse&remoteip=$remoteIp";
        $response = file_get_contents($url);
        $responseKeys = json_decode($response, true);
        if ($responseKeys["success"]) {

            if (isset($_GET['token']) && isset($_POST['resetpassword'])) {
                $token = mysqli_real_escape_string($conn, strip_tags($_GET['token']));
                $password = mysqli_real_escape_string($conn, strip_tags(md5($_POST['resetpassword'])));

                // Validate password strength
                if (strlen($password) < 8) {
                    // Password too short, display error message
                    $_SESSION['error'] = 'Password must be at least 8 characters long!';
                    header("Location: reset-password.php?token= . $token", true, 302);
                    exit();
                }

                // Update user password and remove token from database
                $query = "UPDATE users SET pass = '$password', reset_token = NULL WHERE reset_token = '$token'";
                $result = mysqli_query($conn, $query);

                if ($result) {
                    // Password updated, redirect to login page
                    $_SESSION['success'] = 'Password Updated Sucessfully!';
                    header("Location: login.php");
                    exit();
                } else {
                    // Database error
                    $_SESSION['error'] = "Failed to update password. Please try again later.";
                    header("Location: reset-password.php?token= . $token", true, 302);
                    exit();
                }
            } else {
                $_SESSION['error'] = "Please provide new password.";
                header("Location: reset-password.php?token= . $token", true, 302);
                exit();
            }
        } else {
            // Captcha verification failed, show error message
            session_start();
            $_SESSION["error"] = "reCaptcha verification failed!";
            header("Location: reset-password.php?token= . $token", true, 302);
            exit();
        }
    } else {
        // Captcha verification config failed, show error message
        session_start();
        $_SESSION["error"] = "reCaptcha miss configured!";
        header("Location: reset-password.php?token= . $token", true, 302);
        exit();
    }
} else {
    header("Location: login.php", true, 302);
    session_abort();
    exit();
}
?>