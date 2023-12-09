<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password?</title>
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
                        <h5 class="card-title text-center mb-5 fw-light fs-5">Don't you worry!</h5>
                        <form method="post" action="reset.php">

                            <div class="form-floating mb-3">
                                <label for="floatingInputEmail text-center">Please enter your account's email
                                    address.</label>
                                <input type="email" name="resetemail" class="form-control" id="floatingInputEmail"
                                    placeholder="name@example.com" required>
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
                                    name="submit">
                            </div>
                            <div class="d-flex align-items-end flex-column bd-highlight mb-1">
                                <a class="d-block  mt-2 small" href="login.php">Remembered the Password?</a>
                            </div>
                            <div class="d-flex align-items-end flex-column bd-highlight mb-1">

                                <a class="d-block  mt-2 small" href="index.php">Are you new here? Register</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="js/app.js"></script>

</body>

</html>