<?php

// Database credentials
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "lab";

// Establish a database connection
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
else{
    // echo "We are connected xD";
}

?>
