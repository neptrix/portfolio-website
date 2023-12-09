<?php
// start session
session_start();

// include database connection file
require_once('db/conn.php');

// check if user has submitted the form
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['g-recaptcha-response'])) {

    $secretKey = "6LfYAzwkAAAAAAq4A6M953A6x9qrota1J1b7IC_a";
    $captchaResponse = $_POST['g-recaptcha-response'];
    $remoteIp = $_SERVER['REMOTE_ADDR'];

    // Verify the captcha response
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$captchaResponse&remoteip=$remoteIp";
    $response = file_get_contents($url);
    $responseKeys = json_decode($response, true);
    if ($responseKeys["success"]) {
        if (isset($_POST['submit'])) {
            // sanitize and store user input
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = md5($_POST['password']);
            // query to check if user exists in database
            $query = "SELECT * FROM users WHERE email = '$email' AND pass = '$password' LIMIT 1";
            $result = mysqli_query($conn, $query);

            // check if query returned a result
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                // check if the account is verified ot not
                if ($row['verification_code'] == null) {
                    // user exists, store user data in session and redirect to home page
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['user_type'] = $row['user_type'];
                    $_SESSION['fullname'] = $row['fullname'];
                    $_SESSION['avatar'] = $row['avatar'];
                    $_SESSION['user_email'] = $row['email'];
                    if (isset($_POST['rememberMe'])) {
                        setcookie('email', $email, time() + (86400 * 30), "/"); // expires in 30 days
                        setcookie('password', $password, time() + (86400 * 30), "/"); // expires in 30 days
                    }
                    header('Location: home.php');
                    exit();
                } else {
                    // user doesn't exist, show error message
                    $_SESSION['error_msg'] = 'Please verify your email address before logging in.';
                    header("Location: login.php", true, 302);
                    exit();
                }
            } else {
                // user doesn't exist, show error message
                $_SESSION['error_msg'] = 'Invalid email or password';
                header("Location: login.php", true, 302);
                exit();
            }
        }
    } else {
        // Captcha verification failed, show error message
        session_start();
        $_SESSION["error_msg"] = "reCaptcha verification failed!";
        header("Location:login.php");
        exit();
    }
} else {
    header("Location: login.php", true, 302);
    session_abort();
    exit();
}
?>