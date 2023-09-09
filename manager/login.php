<?php session_start(); ?>
<?php require_once('../inc/connection.php'); ?>
<?php require_once('../inc/functions.php'); ?>
<?php

// check for form submission
if (isset($_POST['submit'])) {

	$errors = array();

	// check if the username and password has been entered
	if (!isset($_POST['email']) || strlen(trim($_POST['email'])) < 1) {
		$errors[] = 'Username is Missing / Invalid';
	}

	if (!isset($_POST['password']) || strlen(trim($_POST['password'])) < 1) {
		$errors[] = 'Password is Missing / Invalid';
	}

	// check if there are any errors in the form
	if (empty($errors)) {
		// save username and password into variables
		$email 		= mysqli_real_escape_string($connection, $_POST['email']);
		$password 	= mysqli_real_escape_string($connection, $_POST['password']);
		$hashed_password = sha1($password);

		// prepare database query
		$query = "SELECT * FROM manager 
						WHERE email = '{$email}' 
						AND password = '{$hashed_password}' 
						LIMIT 1";

		$result_set = mysqli_query($connection, $query);

		verify_query($result_set);

		if (mysqli_num_rows($result_set) == 1) {
			// valid user found
			$user = mysqli_fetch_assoc($result_set);
			$_SESSION['user_id'] = $user['m_id'];
			$_SESSION['first_name'] = $user['first_name'];
			// updating last login
			$query = "UPDATE manager SET last_login = NOW() ";
			$query .= "WHERE m_id = {$_SESSION['user_id']} LIMIT 1";

			$result_set = mysqli_query($connection, $query);

			verify_query($result_set);

			// redirect to users.php
			header('Location: dashboard.php');
		} else {
			// user name and password invalid
			$errors[] = 'Invalid Username / Password';
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<title>OZONE | Manager Login</title>
	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="description" content="" />
	<meta name="keywords" content="">
	<meta name="author" content="Phoenixcoded" />
	<!-- Favicon icon -->
	<link rel="icon" href="images/testlogo.ico" type="image/x-icon">

	<!-- vendor css -->
	<link rel="stylesheet" href="dist/assets/css/style.css">




</head>

<body>



	<!-- [ auth-signin ] start -->
	<div class="auth-wrapper">
		<div class="auth-content text-center">
			<!-- <img src="dist/assets/images/logo.png" alt="" class="img-fluid mb-4"> -->
			<div class="card borderless">
				<div class="row align-items-center ">
					<div class="col-md-12">
						<div class="card-body">
							<form action="login.php" method="post">
								<h4 class="mb-3 f-w-400">Manager Login</h4>

								<!-- [Star Alert] -->
								<?php
								if (isset($_SESSION['status'])) {
								?>
									<div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
										<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
											<use xlink:href="#check-circle-fill" />
										</svg>
										<div class="mt-2">
											<?php
											echo $_SESSION['status'];
											?>
										</div>
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									</div>
								<?php
									unset($_SESSION['status']);
								}
								?>

								<?php
								if (isset($errors) && !empty($errors)) {
								?>
									<div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
										<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
											<use xlink:href="#check-circle-fill" />
										</svg>
										<div class="mt-2">
											<?php
											echo '<p class="error">Invalid Username / Password!</p>';
											?>
										</div>
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									</div>
								<?php
								}
								?>

								<hr>
								<div class="align-items-center text-left">
									<label for="inputEmail4">Email</label>
								</div>
								<div class="form-group mb-3">
									<input type="email" name="email" class="form-control" id="Email" placeholder="Email address" required>
								</div>
								<div class="align-items-center text-left">
									<label for="inputEmail4">Password</label>
								</div>
								<div class="form-group mb-4">
									<input type="password" name="password" class="form-control" id="Password" placeholder="Password" required>
								</div>
								<button class="btn btn-block btn-primary mb-4" name="submit">Signin</button>
								<hr>
								<p class="mb-2 text-muted">Forgot password? <a href="reset_password.php" class="f-w-400">Reset</a></p>
							</form>
							<div>
								<p class="mb-0 text-muted"><a href="../index.php" class="f-w-400">Back To Home</a></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- [ auth-signin ] end -->

	<!-- Required Js -->
	<script src="dist/assets/js/vendor-all.min.js"></script>
	<script src="dist/assets/js/plugins/bootstrap.min.js"></script>
	<script src="dist/assets/js/pcoded.min.js"></script>



</body>

</html>
<?php
mysqli_close($connection);
?>