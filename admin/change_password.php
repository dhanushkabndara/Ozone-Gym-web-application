<?php session_start(); ?>
<?php require_once('../inc/connection.php'); ?>
<?php require_once('../inc/functions.php'); ?>
<?php
// checking if a user is logged in
if (!isset($_SESSION['user_id'])) {
	header('Location: index.php');
}

$errors = array();
$password = '';
$re_password = '';

if (isset($_POST['submit'])) {
	$password = $_POST['password'];
	$re_password = $_POST['re_password'];

	// checking required fields
	$req_fields = array('password', 're_password');
	$errors = array_merge($errors, check_req_fields($req_fields));

	// checking max length
	$max_len_fields = array('password' => 40, 're_password' => 40);
	$errors = array_merge($errors, check_max_len($max_len_fields));

	// checking email address
	if (($_POST['password']) != ($_POST['re_password'])) {
		$errors[] = 'Password is missmatched.';
	}

	if (empty($errors)) {
		// no errors found... adding new record
		$password 	= mysqli_real_escape_string($connection, $_POST['password']);
		$hashed_password = sha1($password);
		// email address is already sanitized

		$query = "UPDATE manager SET ";
		$query .= "password = '{$hashed_password}' ";
		$query .= "WHERE m_id = {$_SESSION['user_id']} LIMIT 1";

		$result = mysqli_query($connection, $query);

		if ($result) {
			// query successful... redirecting to users page
			$_SESSION['status'] = "Successfully Password Changed!. ";
			header('Location: login.php?user_modified=true');
		} else {
			$errors[] = 'Failed to modify the record.';
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<title>Ozone - Reset Password</title>
	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="description" content="" />
	<meta name="keywords" content="">
	<meta name="author" content="Phoenixcoded" />
	<!-- Favicon icon -->
	<!-- <link rel="icon" href="dist/assets/images/favicon.ico" type="image/x-icon"> -->

	<!-- vendor css -->
	<link rel="stylesheet" href="dist/assets/css/style.css">




</head>

<!-- [ auth-signup ] start -->
<div class="auth-wrapper">
	<div class="auth-content text-center">
		<!-- <img src="dist/assets/images/logo.png" alt="" class="img-fluid mb-4"> -->
		<div class="card borderless">
			<div class="row align-items-center text-center">
				<div class="col-md-12">
					<div class="card-body">
						<form action="change_password.php" method="post">
							<h4 class="f-w-400">Reset Passsword</h4>

							<!-- [ dismiss-alert ] start -->
							<?php
							if (!empty($errors)) {
							?>
								<div class="col-md-4">
									<div class="alert alert-danger alert-dismissible fade show" role="alert">
										<strong>
											<?php
											display_errors($errors);
											?>
										</strong>
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									</div>
								</div>
							<?php

							}
							?>
							<!-- [ dismiss-alert ] end -->
							
							<hr>
							<div class="align-items-center text-left">
								<label for="inputEmail4">Password</label>
							</div>
							<div class="form-group mb-4">
								<input type="password" name="password" class="form-control" id="Password" placeholder="Password">
							</div>
							<div class="align-items-center text-left">
								<label for="inputEmail4">Conform Password</label>
							</div>
							<div class="form-group mb-4">
								<input type="password" name="re_password" class="form-control" id="Password" placeholder="Password">
							</div>
							<button class="btn btn-primary btn-block mb-4" name="submit">Conform</button>
							<hr>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- [ auth-signup ] end -->

<!-- Required Js -->
<script src="dist/assets/js/vendor-all.min.js"></script>
<script src="dist/assets/js/plugins/bootstrap.min.js"></script>
<script src="dist/assets/js/pcoded.min.js"></script>
<script src="js/jquery.js"></script>


</body>

</html>