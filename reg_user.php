<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php

$errors = array();
$first_name = '';
$last_name = '';
$email = '';
$gender = '';
$address = '';
$tpnumber = '';
$password = '';

if (isset($_POST['submit'])) {

	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$email = $_POST['email'];
	$gender = $_POST['gender'];
	$address = $_POST['address'];
	$tpnumber = $_POST['tpnumber'];
	$password = $_POST['password'];

	// checking required fields
	$req_fields = array('first_name', 'last_name', 'email', 'gender', 'address', 'tpnumber', 'password');
	$errors = array_merge($errors, check_req_fields($req_fields));

	// checking max length
	$max_len_fields = array('first_name' => 50, 'last_name' => 100, 'email' => 100, 'gender' => 20, 'address' => 100, 'tpnumber' => 20, 'password' => 40);
	$errors = array_merge($errors, check_max_len($max_len_fields));

	// checking email address
	if (!is_email($_POST['email'])) {
		$errors[] = 'Email address is invalid.';
	}

	// checking if email address already exists
	$email = mysqli_real_escape_string($connection, $_POST['email']);
	$query = "SELECT * FROM user WHERE email = '{$email}' LIMIT 1";

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
		$gender = mysqli_real_escape_string($connection, $_POST['gender']);
		$address = mysqli_real_escape_string($connection, $_POST['address']);
		$tpnumber = mysqli_real_escape_string($connection, $_POST['tpnumber']);
		$password = mysqli_real_escape_string($connection, $_POST['password']);
		// email address is already sanitized
		$hashed_password = sha1($password);

		$query = "INSERT INTO user ( ";
		$query .= "first_name, last_name, email, gender, address, tpnumber, password, is_deleted";
		$query .= ") VALUES (";
		$query .= "'{$first_name}', '{$last_name}', '{$email}', '{$gender}', '{$address}', '{$tpnumber}', '{$hashed_password}', 0";
		$query .= ")";

		$result = mysqli_query($connection, $query);

		if ($result) {
			$_SESSION['status'] = "Registration Successfull.!";
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

	<title>Ozone Fitness Center</title>
	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="description" content="" />
	<meta name="keywords" content="">
	<meta name="author" content="Phoenixcoded" />
	<!-- Favicon icon -->
	<link rel="icon" href="" type="image/x-icon">

	<!-- vendor css -->
	<link rel="stylesheet" href="dist/assets/css/style.css">




</head>

<body  style="background-image: url('images/slide-01.jpg');">

	<!-- [ Header ] start -->
	<header class="navbar pcoded-header navbar-expand-lg navbar-light header-dark">


		<div class="m-header">
			<a href="#!" class="b-brand">
				<!-- ========   change your logo hear   ============ -->
				<!-- <img src="dist/assets/images/logo.png" alt="" class="logo"> -->
				<!--<img src="dist/assets/images/logo-icon.png" alt="" class="logo-thumb">-->
				<h5 class="text-white text-center">OZONE FITNESS</h5>
			</a>
			<a href="#!" class="mob-toggler">
				<i class="feather icon-more-vertical"></i>
			</a>
		</div>
		<div class="collapse navbar-collapse align-items-right">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<div class="dropdown">
						<a class="dropdown-toggle h-drop" href="index.php">
							Home
						</a>
					</div>
				</li>
				<li class="nav-item">
					<div class="dropdown mega-menu">
						<a class="dropdown-toggle h-drop" href="#" data-toggle="dropdown">
							Services
						</a>

					</div>
				</li>
				<li class="nav-item">
					<div class="dropdown">
						<a class="dropdown-toggle h-drop" href="index.php" data-toggle="dropdown">
							Contact
						</a>
					</div>
				</li>
				<li class="nav-item">
					<div class="dropdown mega-menu">
						<a class="dropdown-toggle h-drop" href="#" data-toggle="dropdown">
							About Us
						</a>

					</div>
				</li>
			</ul>
			<ul class="navbar-nav ml-auto">
				<li>
					<div class="dropdown">
						<a class="dropdown-toggle" href="#" data-toggle="dropdown">
							<i class="icon feather icon-bell"></i>
							<span class="badge badge-pill badge-danger"></span>
						</a>
						<div class="dropdown-menu dropdown-menu-right notification">
							<div class="noti-head">
								<h6 class="d-inline-block m-b-0">Notifications</h6>
								<div class="float-right">
									<a href="#!" class="m-r-10">mark as read</a>
									<a href="#!">clear all</a>
								</div>
							</div>
							<div class="noti-footer">
								<a href="#!">show all</a>
							</div>
						</div>
					</div>
				</li>
				<li>
					<div class="dropdown drp-user">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="feather icon-user"></i>
						</a>
						<div class="dropdown-menu dropdown-menu-right profile-notification">
							<div class="pro-head">
								<!--<img src="assets/images/user/avatar-1.jpg" class="img-radius" alt="User-Profile-Image">-->
								<!--<span>John Doe</span>-->
								<a href="auth-signin.html" class="dud-logout" title="Logout">
									<i class="feather icon-log-out"></i>
								</a>
							</div>
							<ul class="pro-body">
								<li><a href="user-profile.html" class="dropdown-item"><i class="feather icon-user"></i> Profile</a></li>
								<li><a href="email_inbox.html" class="dropdown-item"><i class="feather icon-mail"></i> My Messages</a></li>
								<li><a href="auth-signin.html" class="dropdown-item"><i class="feather icon-lock"></i> Lock Screen</a></li>
							</ul>
						</div>
					</div>
				</li>
			</ul>
		</div>


	</header>
	<!-- [ Header ] end -->

	<!-- [ dismiss-alert ] start -->
	<?php
	if (!empty($errors)) {
	?>
		<div class="col-md-4 text-center">
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

	<!-- [ auth-signup ] start -->
	<div class="auth-wrapper">
		<div class="auth-content text-center">
			<img src="" alt="" class="img-fluid mb-4">
			<div class="card borderless">
				<div class="row align-items-center text-center">
					<div class="col-md-12">
						<div class="card-body">
							<form action="reg_user.php" method="post" autocomplete="off">
								<h4 class="f-w-400 font-weight-bold">Sign up</h4>

								<hr>
								<div class="align-items-center text-left">
									<label for="inputEmail4">First Name</label>
								</div>
								<div class="form-group mb-3">
									<input type="text" name="first_name" class="form-control" id="Username" placeholder="First Name" required>
								</div>
								<div class="align-items-center text-left">
									<label for="inputEmail4">Last Name</label>
								</div>
								<div class="form-group mb-3">
									<input type="text" name="last_name" class="form-control" id="Username" placeholder="Last Name" required>
								</div>
								<div class="align-items-center text-left">
									<label for="inputEmail4">Email</label>
								</div>
								<div class="form-group mb-3">
									<input type="email" name="email" class="form-control" id="Email" placeholder="Email address" required>
								</div>
								<div class="align-items-center text-left">
									<label for="inputEmail4">Gender</label>
								</div>
								<div class="form-group">
									<select class="form-control" id="exampleFormControlSelect1" name="gender" required>
										<option value="">Select Gender</option>
										<option value="male">Male</option>
										<option value="female">Female</option>
									</select>
								</div>
								<div class="align-items-center text-left">
									<label for="inputEmail4">Address</label>
								</div>
								<div class="form-group mb-3">
									<input type="text" name="address" class="form-control" id="address" placeholder="Address" required>
								</div>
								<div class="align-items-center text-left">
									<label for="inputEmail4">Telephone Number</label>
								</div>
								<div class="form-group mb-3">
									<input type="text" name="tpnumber" class="form-control" id="tpnumber" placeholder="Telephone Number" required>
								</div>
								<div class="align-items-center text-left">
									<label for="inputEmail4">Password</label>
								</div>
								<div class="form-group mb-4">
									<input type="password" name="password" class="form-control" id="Password" placeholder="Password" required>
								</div>
								<div class="custom-control custom-checkbox  text-left mb-4 mt-2">
									<input type="checkbox" class="custom-control-input" id="customCheck1" checked>
									<label class="custom-control-label" for="customCheck1">Agree to Terms and Conditions.</label>
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

	<!-- [ footer ] start -->
	<footer>
		<nav class="navbar fixed-bottom navbar-dark bg-dark">
			<div class="container mt-2 text-white text-center">
				<div class="col-md-12">
					<div>
						<p>
							Copyright &copy;
							<script>
								document.write(new Date().getFullYear());
							</script> All rights reserved.
							<b>
								Ozone Fitness Center
							</b>
						</p>
					</div>
				</div>
			</div>
		</nav>
	</footer>
	<!-- [ footer ] end -->

	<!-- Required Js -->
	<script src="dist/assets/js/vendor-all.min.js"></script>
	<script src="dist/assets/js/plugins/bootstrap.min.js"></script>
	<script src="dist/assets/js/pcoded.min.js"></script>



</body>

</html>