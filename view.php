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
        <title>ViewUsers</title>
    </head>
    <body>
    <table class="table table-bordered table-striped table-hover" id="myTable">
		<thead>
			<tr>
			   <th class="text-center" scope="col">S.No.</th>
				<th class="text-center" scope="col">Name</th>
				<th class="text-center" scope="col">Email</th>
				<th class="text-center" scope="col">Delete</th>
				<th class="text-center" scope="col">Disable</th>
				<th class="text-center" scope="col">Reset</th>
			</tr>
		</thead>
        <?php
            $prepare_query = "select * from users order by 1 desc";
            $exec_query = mysqli_query($conn, $prepare_query);
            while ($row = mysqli_fetch_array($exec_query)) {
                $isID = $row['id'];
                $isName = $row['fullname'];
                $isEmail = $row['email'];
                echo "
                <tr>
                <td class='text-center'>$isID</td>
                <td class='text-center'>$isName</td>
                <td class='text-center'>$isEmail</td>
                <td class='text-center'>
					<span>
					<a href='./delete.php?isID=$isID' class='btn btn-danger mr-3 profile' data-toggle='modal' data-target='#delete$isID' title='Prfile'><i class='fa fa-address-card-o' aria-hidden='true'></i>Delete</a>
					</span>
					
				</td>
                <td class='text-center'>
					<span>
					<a href='./disable.php?isID=$isID' class='btn btn-warning mr-3 profile' data-toggle='modal' data-target='#disable$isID' title='Prfile'><i class='fa fa-address-card-o' aria-hidden='true'></i>Disable</a>
					</span>
					
				</td>
                <td class='text-center'>
					<span>
					<a href='./resetPass.php?isID=$isID' class='btn btn-success mr-3 profile' data-toggle='modal' data-target='#reset$isID' title='Prfile'><i class='fa fa-address-card-o' aria-hidden='true'></i>Reset</a>
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