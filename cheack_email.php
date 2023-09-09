<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php

// check for form submission
if (isset($_POST['submit'])) {

	$errors = array();

	// check if the username and password has been entered
	if (!isset($_POST['email']) || strlen(trim($_POST['email'])) < 1) {
		$errors[] = 'Username is Missing / Invalid';
	}

	/**if (!isset($_POST['password']) || strlen(trim($_POST['password'])) < 1) {
		$errors[] = 'Password is Missing / Invalid';
	}*/

	// check if there are any errors in the form
	if (empty($errors)) {
		// save username and password into variables
		$email 		= mysqli_real_escape_string($connection, $_POST['email']);
		/**$password 	= mysqli_real_escape_string($connection, $_POST['password']);
		$hashed_password = sha1($password);*/

		// prepare database query
		$query = "SELECT * FROM user 
						WHERE email = '{$email}'
						LIMIT 1";

		$result_set = mysqli_query($connection, $query);

		verify_query($result_set);

		if (mysqli_num_rows($result_set) == 1) {
			// valid user found
			$user = mysqli_fetch_assoc($result_set);
			$_SESSION['user_id'] = $user['id'];
			//$_SESSION['first_name'] = $user['first_name'];
			// updating last login
			/**$query = "UPDATE user SET last_login = NOW() ";
			$query .= "WHERE id = {$_SESSION['user_id']} LIMIT 1";*/

			$result_set = mysqli_query($connection, $query);

			verify_query($result_set);

			// redirect to users.php
			header('Location: reset_password.php?user_found=true');
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
						<form action="cheack_email.php" method="post">
							<h4 class="f-w-400">Reset Passsword</h4>
							<?php

							if (!empty($errors)) {
								display_errors($errors);
							}

							?>
							<hr>
							<div class="align-items-center text-left">
								<label for="inputEmail4">Email</label>
							</div>
							<div class="form-group mb-3">
								<input type="text" name="email" class="form-control" id="Email" placeholder="Email address">
							</div>
							<button class="btn btn-primary btn-block mb-4" name="submit">Submit</button>
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