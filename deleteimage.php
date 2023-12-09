<?php
    include_once("./db/conn.php");
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
    $getUserID = $_GET['isID'];
    $prepare_query = "update users set avatar = '' where id = $getUserID";
    $run_query = mysqli_query($conn, $prepare_query);
    if ($run_query) {
        header("Location: viewImage.php");
    }
?>