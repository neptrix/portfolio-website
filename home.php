<?php
// start session
session_start();

// check if user is logged in, redirect to login page if not
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
} else {
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Home</title>
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
                        <div class="card-body p-4 p-sm-5">
                            <h4 class="card-title text-center mb-5 fw-light fs-5">Welcome
                                <?php echo $_SESSION['fullname']; ?>
                            </h4>
                            <form method="post" action="update.php" enctype="multipart/form-data">

                                <div class="text-center">
                                    <img src="images/avatar/<?php echo $_SESSION['avatar'];?>" style="width: 120px; height: 120px; border-style: solid; border-color: red;" class="rounded">
                                </div>
                                <div class="form-floating mb-3">
                                    <label for="floatingInputEmail">Email</label>
                                    <input type="email" name="email" class="form-control" id="floatingInputEmail"
                                        placeholder="name@example.com" value="<?php echo $_SESSION['user_email']; ?>"
                                        disabled>
                                </div>

                                <div class="form-floating mb-3">
                                    <label for="floatingInputName">Change Full Name</label>
                                    <input type="text" class="form-control" id="floatingInputName"
                                        placeholder="Hari Bahadur" name="fullname"
                                        value="<?php echo $_SESSION['fullname']; ?>">
                                </div>

                                <div class="form-floating mb-3">
                                    <label for="floatingInputAvatar">Change Avatar</label>
                                    <input type="file" class="form-control" id="floatingInputAvatar"
                                    accept="image/*" name="avatar">   
                                </div>

                                <hr>
                                <div class="text-muted text-sm text-center">
                                    <span>Keep it empty if you do not want to change the password.</span>
                                </div>
                                <div class="form-floating mb-3">
                                    <label for="floatingPassword">Change Password</label>
                                    <input type="password" name="password" class="form-control" id="floatingPassword"
                                        placeholder="Password">
                                </div>

                                <div class="form-floating mb-3">
                                    <label for="floatingPassword">Confirm Password</label>
                                    <input type="password" name="cpassword" class="form-control" id="floatingCPassword"
                                        placeholder="Re-enter Password">
                                </div>
                                <div class="form-floating mb-3">
                                    <!-- <label for="captcha">Enter the code shown:</label>
                            <img src="helpers/captcha.php" alt="CAPTCHA">
                            <input type="text" id="captcha" class="form-control" name="captcha" required> -->
                                    <div class="g-recaptcha d-flex justify-content-center mt-3"
                                        data-sitekey="6LfYAzwkAAAAAAaxYsd4ghvuEch8GUhSUFx9c5h1"></div>
                                </div>
                                <div class="d-grid mb-2 text-center">
                                    <input class="btn btn-lg btn-primary btn-login fw-bold text-uppercase" type="submit"
                                        value="Update" name="submit">
                                </div>
                                <div class="text-center mt-5">
                                    <?php
                                    if (isset($_SESSION['error_msg'])) {
                                        echo '<p class="error">' . $_SESSION['error_msg'] . '</p>';
                                        unset($_SESSION['error_msg']);
                                    }
                                    ?>
                                    <?php
                                    if (isset($_SESSION['success'])) {
                                        echo '<p class="success">' . $_SESSION['success'] . '</p>';
                                        unset($_SESSION['success']);
                                    }
                                    ?>
                                </div>
                            </form>
                            <?php
                            if ($_SESSION['user_type'] === '1') {
                                ?>
                                <!-- Additional Admin Permissions -->
                                <h4 class="card-title text-center mb-5 fw-light fs-5">
                                    Admin Permissions
                                    <hr>
                                </h4>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm text-center">
                                        <a href="./view.php" class="btn btn-primary btn-lg">View All Users</a>
                                        </div>
                                        <div class="col-sm text-center">
                                        <a href="./viewImage.php" class="btn btn-success btn-lg">View All Images</a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
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
    <?php
}
?>