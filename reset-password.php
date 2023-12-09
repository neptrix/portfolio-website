<?php
require_once('db/conn.php');

// Start session and connect to database
session_start();

// Check if token is provided in URL
if (isset($_GET['token'])) {
    $token = mysqli_real_escape_string($conn, strip_tags($_GET['token']));

    // Verify token exists in database
    $query = "SELECT * FROM users WHERE reset_token = '$token'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        ?>
        <!DOCTYPE html>
        <html>

        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Reset Password</title>
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
                                <h5 class="card-title text-center mb-5 fw-light fs-5">Reset Password</h5>

                                <form method="post" action="update-password.php?token=<?php echo $token; ?>">
                                    <div class="form-floating mb-3">
                                        <label for="floatingInputPassword text-center">New password</label>
                                        <input type="password" name="resetpassword" class="form-control"
                                            id="floatingInputPassword" required>
                                    </div>

                                    <hr>
                                    <div class="form-floating mb-3">
                                        <div class="g-recaptcha d-flex justify-content-center mt-3"
                                            data-sitekey="6LfYAzwkAAAAAAaxYsd4ghvuEch8GUhSUFx9c5h1"></div>
                                    </div>
                                    <?php
                                    if (isset($_SESSION['error'])) {
                                        echo '<p class="error">' . $_SESSION['error'] . '</p>';
                                        unset($_SESSION['error']);
                                    }
                                    ?>
                                    <?php
                                    if (isset($_SESSION['success'])) {
                                        echo '<p class="success">' . $_SESSION['success'] . '</p>';
                                        unset($_SESSION['success']);
                                    }
                                    ?>
                                    <div class="d-grid mb-2 text-center">
                                        <input class="btn btn-lg btn-primary btn-login fw-bold text-uppercase " type="submit"
                                            name="submit" value="update">
                                    </div>
                                    <div class="text-center">
                                    <?php
                                    if (isset($_SESSION['error'])) {
                                        echo '<p class="error">' . $_SESSION['error'] . '</p>';
                                        unset($_SESSION['error']);
                                    }
                                    ?>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <?php
    } else {
        // Token not found

        echo "<p class='error'>Invalid token code!!</p><a href='index.php' class='btn btn-outline-primary my-2 my-sm-0'>Go Home</a>";

    }
} else {
    // Token not found
    $msg = "<p class='error'>No token code!!</p><a href='index.php' class='btn btn-outline-primary my-2 my-sm-0'>Go Home</a>";
}
?>