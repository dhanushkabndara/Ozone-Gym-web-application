<?php session_start(); ?>
<?php require_once('../inc/connection.php'); ?>
<?php require_once('../inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	/**if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	} */

	$errors = array();
	$first_name = '';
	$last_name = '';
	$email = '';
	$password = '';

	if (isset($_POST['submit'])) {
		
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$email = $_POST['email'];
		$password = $_POST['password'];

		// checking required fields
		$req_fields = array('first_name', 'last_name', 'email', 'password');
		$errors = array_merge($errors, check_req_fields($req_fields));

		// checking max length
		$max_len_fields = array('first_name' => 50, 'last_name' =>100, 'email' => 100, 'password' => 40);
		$errors = array_merge($errors, check_max_len($max_len_fields));

		// checking email address
		if (!is_email($_POST['email'])) {
			$errors[] = 'Email address is invalid.';
		}

		// checking if email address already exists
		$email = mysqli_real_escape_string($connection, $_POST['email']);
		$query = "SELECT * FROM manager WHERE email = '{$email}' LIMIT 1";

		$result_set = mysqli_query($connection, $query);

		if ($result_set) {
			if (mysqli_num_rows($result_set) == 1) {
				$errors[] = 'Email address already exists';
			}
		}

		if (empty($errors)) {
			// no errors found... adding new record
			$first_name = mysqli_real_escape_string($connection, $_POST['first_name']);
			$last_name = mysqli_real_escape_string($connection, $_POST['last_name']);
			$password = mysqli_real_escape_string($connection, $_POST['password']);
			// email address is already sanitized
			$hashed_password = sha1($password);

			$query = "INSERT INTO manager ( ";
			$query .= "first_name, last_name, email, password, is_deleted";
			$query .= ") VALUES (";
			$query .= "'{$first_name}', '{$last_name}', '{$email}', '{$hashed_password}', 0";
			$query .= ")";

			$result = mysqli_query($connection, $query);

			if ($result) {
				// query successful... redirecting to users page
				header('Location: login.php?user_added=true');
			} else {
				$errors[] = 'Failed to add the new record.';
			}


		}



	}



?>
<!DOCTYPE html>
<html lang="en">

<head>

	<title>Register | Manager</title>
	<!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 11]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="description" content="" />
	<meta name="keywords" content="">
	<meta name="author" content="Phoenixcoded" />
	<!-- Favicon icon -->
	<link rel="icon" href="dist/assets/images/favicon.ico" type="image/x-icon">

	<!-- vendor css -->
	<link rel="stylesheet" href="dist/assets/css/style.css">
	
	


</head>

<!-- [ auth-signup ] start -->
<div class="auth-wrapper">
	<div class="auth-content text-center">
		<img src="dist/assets/images/logo.png" alt="" class="img-fluid mb-4">
		<div class="card borderless">
			<div class="row align-items-center text-center">
				<div class="col-md-12">
					<div class="card-body">
						<form method="post">
						<h4 class="f-w-400">Sign up</h4>
                        <?php 

                            if (!empty($errors)) {
                                display_errors($errors);
                            }
						?>
						<hr>
						<div class="form-group mb-3">
							<input type="text" name="first_name" class="form-control" id="Username" placeholder="First Name" <?php echo 'value="' . $first_name . '"'; ?>>
						</div>
						<div class="form-group mb-3">
							<input type="text" name="last_name" class="form-control" id="Username" placeholder="Last Name" <?php echo 'value="' . $last_name . '"'; ?>>
						</div>
						<div class="form-group mb-3">
							<input type="text" name="email" class="form-control" id="Email" placeholder="Email address" <?php echo 'value="' . $email . '"'; ?>>
						</div>
						<div class="form-group mb-4">
							<input type="password" name="password" class="form-control" id="Password" placeholder="Password">
						</div>
						<div class="custom-control custom-checkbox  text-left mb-4 mt-2">
							<input type="checkbox" class="custom-control-input" id="customCheck1">
							<label class="custom-control-label" for="customCheck1">Send me the <a href="#!"> Newsletter</a> weekly.</label>
						</div>
						<button class="btn btn-primary btn-block mb-4" name="submit">Sign up</button>
						<hr>
						<p class="mb-2">Already have an account? <a href="login.php" class="f-w-400">Signin</a></p>
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



</body>

</html>
