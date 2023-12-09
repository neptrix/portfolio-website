<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log In</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
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
                        <h5 class="card-title text-center mb-5 fw-light fs-5">Welcome Back</h5>
                        <form method="post" action="valid.php" autocomplete="on">
                            <?php
                            if (isset($_SESSION['success'])) {
                                echo '<p class="success">' . $_SESSION['success'] . '</p>';
                                unset($_SESSION['success']);
                            }
                            ?>
                            <div class="form-floating mb-3">
                                <label for="floatingInputEmail">Email address</label>
                                <input type="email" name="email" class="form-control" id="floatingInputEmail"
                                    placeholder="name@example.com" required>
                            </div>

                            <hr>

                            <div class="form-floating mb-3">
                                <label for="floatingPassword">Password</label>
                                <input type="password" name="password" class="form-control" id="password"
                                    placeholder="Password" required>
                                <i class="bi bi-eye-slash" id="togglePassword"></i>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="rememberMe" name="rememberMe">
                                <label class="form-check-label" for="rememberMe">Remember me</label>
                            </div>
                            <div class="form-floating mb-3">
                                <!-- <label for="captcha">Enter the code shown:</label>
                            <img src="helpers/captcha.php" alt="CAPTCHA">
                            <input type="text" id="captcha" class="form-control" name="captcha" required> -->
                                <div class="g-recaptcha d-flex justify-content-center mt-3"
                                    data-sitekey="6LfYAzwkAAAAAAaxYsd4ghvuEch8GUhSUFx9c5h1"></div>
                            </div>
                            <?php
                            if (isset($_SESSION['error_msg'])) {
                                echo '<p class="error">' . $_SESSION['error_msg'] . '</p>';
                                unset($_SESSION['error_msg']);
                            }
                            ?>
                            <div class="d-grid mb-2 text-center">
                                <input class="btn btn-lg btn-primary btn-login fw-bold text-uppercase " type="submit"
                                    name="submit">
                            </div>
                            <div class="d-flex align-items-end flex-column bd-highlight mb-1">
                                <a class="d-block  mt-2 small" href="forgotpassword.php">Forgot Password?</a>
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
    <script>
        const togglePassword = document
            .querySelector('#togglePassword');

        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', () => {

            // Toggle the type attribute using
            // getAttribure() method
            const type = password
                .getAttribute('type') === 'password' ?
                'text' : 'password';

            password.setAttribute('type', type);

            // Toggle the eye and bi-eye icon
            togglePassword.classList.toggle('bi-eye');
        });
    </script>
</body>

</html>