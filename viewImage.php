<?php
// start session
require_once("./db/conn.php");
session_start();

// check if user is logged in, redirect to login page if not
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
} else {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
        <title>HandleImage</title>
    </head>
    <body>
    <table class="table table-bordered table-striped table-hover" id="myTable">
		<thead>
			<tr>
			   <th class="text-center" scope="col">S.No.</th>
				<th class="text-center" scope="col">Name</th>
				<th class="text-center" scope="col">Email</th>
				<th class="text-center" scope="col">Image</th>
				<th class="text-center" scope="col">Upload</th>
				<th class="text-center" scope="col">Delete</th>
			</tr>
		</thead>
        <?php
            $prepare_query = "select * from users order by 1 desc";
            $exec_query = mysqli_query($conn, $prepare_query);
            while ($row = mysqli_fetch_array($exec_query)) {
                $isID = $row['id'];
                $isName = $row['fullname'];
                $isEmail = $row['email'];
                $isAvatar = $row['avatar'];
                echo "
                <tr>
                <td class='text-center'>$isID</td>
                <td class='text-center'>$isName</td>
                <td class='text-center'>$isEmail</td>
                
                <td class='text-center'><div class='text-center'>
                <img src='images/avatar/$isAvatar' style='width: 100px;' class='rounded'>
                </div></td>
                <form method='post' action='uploadimage.php' enctype='multipart/form-data'>
                    <td class='text-center'>
                        <div class='form-floating mb-3'>
                            <input type='file' class='form-control' id='floatingInputAvatar'
                            accept='image/*' name='avatar'>
                            <input class='btn btn-lg btn-primary btn-login fw-bold text-uppercase' type='submit' value='Update' name='submit'>
                        </div>
                    </td>
                </form>
                <td class='text-center'>
                    <span>
                        <a href='./deleteimage.php?isID=$isID' class='btn btn-danger mr-3 profile' data-toggle='modal' data-target='#uploadimage$isID' title='Prfile'><i class='fa fa-address-card-o' aria-hidden='true'></i>Delete</a>
                    </span>
                </td>
                </tr>
                ";
            }
        ?>
    </table>
    </body>
    </html>
    <?php
}
?>