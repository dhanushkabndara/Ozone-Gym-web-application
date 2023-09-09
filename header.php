<!DOCTYPE html>
<html lang="en">

<head>
	<title>OZONE - Dsashboard</title>

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

<body class="">

	<?php include 'sidebar.php'; ?>

	<!-- [ Header ] start -->
	<header class="navbar pcoded-header navbar-expand-lg navbar-light header-dark">


		<div class="m-header">
			<a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
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
					<div class="">
						<a class="" href="index.php">
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