<?php
// start session
session_start();

// unset all session variables
session_unset();

// destroy session
session_destroy();

// redirect to login page
header("Location: login.php");
exit();
?>