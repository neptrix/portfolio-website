<?php
require_once('db/conn.php');

// Database connection

if (isset($_GET['code'])) {
    $verificationCode = $_GET['code'];

    // Check if the verification code exists
    $query = "SELECT * FROM users WHERE verification_code = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $verificationCode);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update the verification_code to NULL, indicating the email is verified
        $query = "UPDATE users SET verification_code = NULL WHERE verification_code = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $verificationCode);
        $stmt->execute();

        $msg= "<p class='success'>Email verified successfully!</p> <a href='login.php' class='btn btn-outline-success my-2 my-sm-0'>Login Here</a>";
    } else {
        $msg= "<p class='error'>Invalid verification code!!</p><a href='index.php' class='btn btn-outline-primary my-2 my-sm-0'>Go Home</a>";
    }
    ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Email Verification</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css"
        rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
    <?php include('templates/nav.php'); ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-10 col-xl-9 mx-auto">
                <div class="card flex-row my-5 border-1 shadow rounded-3 overflow-hidden">
                    <div class="card-img-left d-none d-md-flex">
                        <!-- Background image for card set in CSS! -->
                    </div>
                    <div class="card-body p-4 p-sm-5">
                        <h5 class="card-title text-center mb-5 fw-light fs-5">Email Veirfication</h5>
                        <div class="text-center"><?php echo $msg; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
} else {
    header("Location: index.php", true, 302);
    session_abort();
    exit();
}
?>