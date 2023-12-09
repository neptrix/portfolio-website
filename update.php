<?php
session_start();
require_once('db/conn.php');
require_once('helpers/verification.php');
require_once('helpers/generatefilename.php');
// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['g-recaptcha-response'])) {
    // Get the form data
    $user_id = $_SESSION['user_id'];
    $password = md5($_POST['password']);
    $fullname = htmlspecialchars($_POST['fullname'], ENT_QUOTES, 'UTF-8');
    $secretKey = "6LfYAzwkAAAAAAq4A6M953A6x9qrota1J1b7IC_a";
    $captchaResponse = $_POST['g-recaptcha-response'];
    $remoteIp = $_SERVER['REMOTE_ADDR'];

    // Images
    $maxFileSize = 5242880; //5 MB is bytes


    // Verify the captcha response
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$captchaResponse&remoteip=$remoteIp";
    $response = file_get_contents($url);
    $responseKeys = json_decode($response, true);
    if ($responseKeys["success"]) {
        if (isset($_POST['submit'])) {
            if (!$_POST['password'] == null || !$_POST['password'] == '') {

                if ($_POST['password'] === $_POST['cpassword']) {
                    $sql = "UPDATE users SET fullname = ?, pass = ? WHERE id = ?";
                    if ($stmt = mysqli_prepare($conn, $sql)) {
                        mysqli_stmt_bind_param($stmt, "ssi", $fullname, $password, $user_id);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_close($stmt);
                        $_SESSION['fullname'] = $fullname;

                        // Check if an avatar file was uploaded
                        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                            $avatar = $_FILES['avatar'];
                            // Check that the file type is an image
                            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                            if (!in_array($avatar['type'], $allowedTypes)) {
                                $_SESSION['error_msg'] = 'Please upload a valid image file (JPG, PNG, GIF)';
                                header("Location: home.php", true, 302);
                                exit();
                            }
                            // Check that the file size is within the limit
                            if ($avatar['size'] > $maxFileSize) {
                                $_SESSION['error_msg'] = 'The uploaded file exceeds the maximum file size limit (5 MB)';
                                header("Location: home.php", true, 302);
                                exit();
                            }
                        } else {
                            // No avatar file was uploaded
                            $avatar = null;
                        }
                        if (isset($avatar)) {
                            $avatarName = generateFileName($avatar['name']);
                            $avatarPath = 'images/avatar/' . $avatarName;
                            move_uploaded_file($avatar['tmp_name'], $avatarPath);

                            $sql = "UPDATE users SET fullname= ?, avatar = ?, pass = ? WHERE id = ?";
                            if ($stmt = mysqli_prepare($conn, $sql)) {
                                mysqli_stmt_bind_param($stmt, "sssi", $fullname, $avatarName, $password, $user_id);
                                mysqli_stmt_execute($stmt);
                                mysqli_stmt_close($stmt);
                                $_SESSION['fullname'] = $fullname;
                                $_SESSION['avatar'] = $avatarName;
                            }

                            // execute the SQL query
                            $_SESSION['success'] = 'Updated Sucessfully!';
                            header("Location: home.php", true, 302);
                            exit();
                        }
                        // execute the SQL query
                        $_SESSION['success'] = 'Updated Sucessfully!';
                        header("Location: home.php", true, 302);
                        exit();
                    }
                } else {
                    $_SESSION['error_msg'] = 'Both password did not match.';
                    header("Location: home.php", true, 302);
                    exit();
                }
            } else {
                $sql = "UPDATE users SET fullname = ? WHERE id = ?";
                if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, "si", $fullname, $user_id);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                    $_SESSION['fullname'] = $fullname;

                }
                // Check if an avatar file was uploaded
                if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                    $avatar = $_FILES['avatar'];
                    // Check that the file type is an image
                    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    if (!in_array($avatar['type'], $allowedTypes)) {
                        $_SESSION['error_msg'] = 'Please upload a valid image file (JPG, PNG, GIF)';
                        header("Location: home.php", true, 302);
                        exit();
                    }
                    // Check that the file size is within the limit
                    if ($avatar['size'] > $maxFileSize) {
                        $_SESSION['error_msg'] = 'The uploaded file exceeds the maximum file size limit (5 MB)';
                        header("Location: home.php", true, 302);
                        exit();
                    }
                } else {
                    // No avatar file was uploaded
                    $avatar = null;
                }
                if (isset($avatar)) {
                    $avatarName = generateFileName($avatar['name']);
                    $avatarPath = 'images/avatar/' . $avatarName;
                    move_uploaded_file($avatar['tmp_name'], $avatarPath);

                    $sql = "UPDATE users SET fullname= ?, avatar = ? WHERE id = ?";
                    if ($stmt = mysqli_prepare($conn, $sql)) {
                        mysqli_stmt_bind_param($stmt, "ssi", $fullname, $avatarName, $user_id);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_close($stmt);
                        $_SESSION['fullname'] = $fullname;
                        $_SESSION['avatar'] = $avatarName;
                    }
                }
                // execute the SQL query
                $_SESSION['success'] = 'Updated Sucessfully!';
                header("Location: home.php", true, 302);
                exit();
            }

        }
    } else {
        $_SESSION["error_msg"] = "reCaptcha verification failed!";
        header("Location: home.php", true, 302);
        exit();
    }
} else {
    $_SESSION['error_msg'] = 'Please complete the recaptcha.';
    header("Location: home.php", true, 302);
    exit();
}
?>