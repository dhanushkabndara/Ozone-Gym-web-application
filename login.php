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
		$query = "SELECT * FROM user 
						WHERE email = '{$email}' 
						AND password = '{$hashed_password}' 
						LIMIT 1";

		$result_set = mysqli_query($connection, $query);

		verify_query($result_set);

		if (mysqli_num_rows($result_set) == 1) {
			// valid user found
			$user = mysqli_fetch_assoc($result_set);
			$_SESSION['user_id'] = $user['id'];
			$_SESSION['first_name'] = $user['first_name'];
			// updating last login
			$query = "UPDATE user SET last_login = NOW() ";
			$query .= "WHERE id = {$_SESSION['user_id']} LIMIT 1";

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

	<title>OZONE - Log In</title>
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

<body style="background-image: url('images/slide-01.jpg');">

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
		<div class="collapse navbar-collapse align-items-center">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<div class="dropdown">
						<a class="dropdown-toggle" href="index.php">
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

	<!-- [ auth-signin ] start -->
	<div class="auth-wrapper">
		<div class="auth-content text-center">
			<!-- <img src="dist/assets/images/logo.png" alt="" class="img-fluid mb-4"> -->
			<div class="card borderless">
				<div class="row align-items-center">
					<div class="col-md-12">
						<div class="card-body">
							<form action="login.php" method="post">
								<h4 class="mb-3 f-w-400"><b>Sign in</b></h4>

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
									<input type="text" name="email" class="form-control" id="Email" placeholder="Email address" required>
								</div>
								<div class="align-items-center text-left">
									<label for="inputEmail4">Password</label>
								</div>
								<div class="form-group mb-4">
									<input type="password" name="password" class="form-control" id="Password" placeholder="Password" required>
								</div>
								<div class="custom-control custom-checkbox text-left mb-4 mt-2">
									<input type="checkbox" class="custom-control-input" id="customCheck1" checked>
									<label class="custom-control-label" for="customCheck1">Remember me.</label>
								</div>
								<button class="btn btn-block btn-primary mb-4" name="submit">Sign In</button>
								<hr>
								<p class="mb-2 text-muted">Forgot password? <a href="cheack_email.php" class="f-w-400">Reset</a></p>
								<p class="mb-0 text-muted">Don’t have an account? <a href="reg_user.php" class="f-w-400">Signup</a></p>
								<p class="mb-2 text-muted">Manager Login <a href="manager/login.php" class="f-w-400">Login</a></p>
								<p class="mb-2 text-muted">Admin Login <a href="admin/login.php" class="f-w-400">Login</a></p>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- [ auth-signin ] end -->

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
<?php
mysqli_close($connection);
?>