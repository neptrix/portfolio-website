<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Account</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include('templates/nav.php'); ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-10 col-xl-9 mx-auto">
                <div class="card flex-row my-5 border-1 shadow rounded-3 overflow-hidden">
                    
                    <!-- Background image for card set in CSS! -->
                    </div>
                    <div class="card-body p-4 p-sm-5">
                        <h5 class="card-title text-center mb-5 fw-light fs-5">Register</h5>
                        <form method="post" action="store.php">

                            <div class="form-floating mb-3">
                                <label for="floatingInputUsername">Full Name</label>

                                <input type="text" class="form-control" name="fullname" id="floatingInputUsername"
                                    placeholder="Hari Bahadur" required autofocus>
                            </div>

                            <div class="form-floting mb-3">

                            <div class="form-floating mb-3">
                                <label for="floatingInputEmail">Email address</label>

                                <input type="email" class="form-control" name="email" id="floatingInputEmail"
                                    placeholder="name@example.com">
                            </div>
                            <label for= "floatingInputusername">Username </label>

                                <input type="text" class="form-control" name="username" id="floatingInputusername"
                                    placeholder ="username" required autofocus>

                            <div class="form-floating mb-3">
                                <label for="floatingPassword">Password</label>
                                <input type="password" class="form-control" name="password" id="password"
                                    placeholder="Password">
                            </div>
                            <div id="password-strength"></div>
                            <div class="form-floating mb-3">
                                <label for="floatingPasswordConfirm">Confirm Password</label>

                                <input type="password" class="form-control" name="cpassword"
                                    id="floatingPasswordConfirm" placeholder="Confirm Password">
                            </div>
                            <div class="form-floating mb-3">
                                <label for="captcha">Enter the code shown:</label>
                                <img src="helpers/captcha.php" alt="CAPTCHA">
                                <input type="text" id="captcha" class="form-control" name="captcha" required>
                            </div>
                            <?php
                            if (isset($_SESSION['error'])) {
                                echo '<p class="error">' . $_SESSION['error'] . '</p>';
                                unset($_SESSION['error']);
                            }
                            ?>
                            <?php
                            if (isset($_SESSION['success'])) {
                                echo '<p class="success">' . $_SESSION['success'] . ' <a href="login.php"> Login Here </a> </p>';
                                unset($_SESSION['success']);
                            }
                            ?>
                            <div class="d-grid mb-2 text-center">
                                <button class="btn btn-lg btn-primary btn-login fw-bold text-uppercase "
                                    type="submit">Register</button>
                            </div>
                            <div class="d-flex align-items-end flex-column bd-highlight mb-1">

                                <a class="d-block text-center mt-2 small" href="login.php">Have an account? Sign In</a>
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