	<!-- [ navigation menu ] start -->
	<nav class="pcoded-navbar  ">
		<div class="navbar-wrapper  ">
			<div class="navbar-content scroll-div ">

				<div class="">
					<div class="main-menu-header">

						<img class="img-radius" src="dist/assets/images/user/man.png" alt="User-Profile-Image">
						<div class="user-details">
							<span>
								<?php echo $_SESSION['first_name']; ?>
								<!-- display user name -->
							</span>
							<div id="more-details">Welcome<i class="fa fa-chevron-down m-l-5"></i></div>
						</div>
					</div>
					<div class="collapse" id="nav-user-link">
						<ul class="list-unstyled">
							<li class="list-group-item"><a href="user.php"><i class="feather icon-user m-r-5"></i>View Profile</a></li>
							<li class="list-group-item"><a href="settings.php"><i class="feather icon-settings m-r-5"></i>Settings</a></li>
							<li class="list-group-item"><a href="logout.php"><i class="feather icon-log-out m-r-5"></i>Logout</a></li>
						</ul>
					</div>
				</div>

				<ul class="nav pcoded-inner-navbar ">
					<li class="nav-item pcoded-menu-caption">
						<label>Navigation</label>
					</li>
					<li class="nav-item">
						<a href="dashboard.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Dashboard</span></a>
					</li>
					<li class="nav-item pcoded-hasmenu">
						<a href="#" class="nav-link "><span class="pcoded-micon"><i class="feather icon-activity"></i></span><span class="pcoded-mtext">Health Infromation</span></a>
						<ul class="pcoded-submenu">
							<li><a href="add_healthinfo.php" class="nav-link ">Add Infromation</a></li>
							<li><a href="view_healthinfo.php" class="nav-link ">View Infromation</a></li>
							<!--<li><a href="#" target="_blank">Horizontal</a></li>-->
						</ul>
					</li>
					<li class="nav-item pcoded-hasmenu">
						<a href="#" class="nav-link "><span class="pcoded-micon"><i class="feather icon-user"></i></span><span class="pcoded-mtext">View Membership</span></a>
						<ul class="pcoded-submenu">
							<li><a href="membership.php" class="nav-link ">Membership Infromation</a></li>
							<!--<li><a href="#" target="_blank">Horizontal</a></li>-->
						</ul>
					</li>
					<li class="nav-item pcoded-hasmenu">
						<a href="#" class="nav-link "><span class="pcoded-micon"><i class="feather icon-clipboard"></i></span><span class="pcoded-mtext">Packages</span></a>
						<ul class="pcoded-submenu">
							<li><a href="viwe_packages.php" class="nav-link ">View Packages</a></li>
							<!--<li><a href="#" target="_blank">Horizontal</a></li>-->
						</ul>
					</li>
					<li class="nav-item pcoded-hasmenu">
						<a href="#" class="nav-link "><span class="pcoded-micon"><i class="feather icon-credit-card"></i></span><span class="pcoded-mtext">Apply Membership</span></a>
						<ul class="pcoded-submenu">
							<li><a href="payment.php" class="nav-link ">Payment</a></li>
							<li><a href="payment_history.php" class="nav-link">Payment History</a></li>
							<li><a href="viwe_invoice.php" class="nav-link">View Invoice</a></li>
						</ul>
					</li>
					<li class="nav-item pcoded-hasmenu">
						<a href="#" class="nav-link "><span class="pcoded-micon"><i class="feather icon-clipboard"></i></span><span class="pcoded-mtext">Workout Schedule</span></a>
						<ul class="pcoded-submenu">
							<li><a href="view_schedule.php" class="nav-link ">View Schedule</a></li>
							<!--<li><a href="#" target="_blank">Horizontal</a></li>-->
						</ul>
					</li>
				</ul>

			</div>
		</div>
	</nav>
	<!-- [ navigation menu ] end -->