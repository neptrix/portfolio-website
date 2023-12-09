<?php
    include_once("./db/conn.php");
    require_once('helpers/mail.php');
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
    $email;
    $getUserID = $_GET['isID'];
    $fetch_query = "select * from users where id = $getUserID";
    $exec_query = mysqli_query($conn, $fetch_query);
    while($row = mysqli_fetch_array($exec_query)) {
        $email = $row['email'];
    }

    $token = bin2hex(random_bytes(16));
    sendResetEmail($email, $token);
    $prepare_query = "UPDATE users SET reset_token = '$token', disable = '0' WHERE id = '$getUserID'";
    $run_query = mysqli_query($conn, $prepare_query);
    if ($run_query) {
        header("Location: view.php");
    }
?>