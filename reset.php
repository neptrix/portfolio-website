<?php
session_start();
require_once('db/conn.php');
require_once('helpers/mail.php');
// Check if the form was submitted
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

            if ($_POST['resetemail']) {
                // Get the form data
                $email = htmlspecialchars($_POST['resetemail']);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    // Invalid email, display error message
                    $_SESSION['error'] = 'Please enter a email address!';
                    header("Location: forgotpassword.php", true, 302);
                    exit();
                } else {
                    // Check if email exists in database
                    $query = "SELECT * FROM users WHERE email = '$email'";
                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) == 1) {
                        // Email exists, generate token and store in database
                        $token = bin2hex(random_bytes(16));
                        sendResetEmail($email, $token);
                        $query = "UPDATE users SET reset_token = '$token' WHERE email = '$email'";
                        $result = mysqli_query($conn, $query);
                        echo"Done!";
                        $_SESSION['success'] = 'An email has been sent if email is associated with a account.';
                        header("Location: forgotpassword.php", true, 302);
                        exit();
                    } else {
                        $_SESSION['success'] = 'An email has been sent if email is associated with a account.';
                        header("Location: forgotpassword.php", true, 302);
                        exit();
                    }
                }
            } else {
                $_SESSION['error'] = 'No email provided!';
                header("Location: forgotpassword.php", true, 302);
                exit();
            }
        }else {
            // Captcha verification failed, show error message
            session_start();
            $_SESSION["error"] = "reCaptcha verification failed!";
            header("Location:forgotpassword.php");
            exit();
        }
    } else {
        // Captcha verification config failed, show error message
        session_start();
        $_SESSION["error"] = "reCaptcha miss configured!";
        header("Location:forgotpassword.php");
        exit();
    }
} else {
    header("Location: login.php", true, 302);
    session_abort();
    exit();
}
?>