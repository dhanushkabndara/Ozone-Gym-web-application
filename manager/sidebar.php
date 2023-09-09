	<!-- [ navigation menu ] start -->
	<nav class="pcoded-navbar  ">
		<div class="navbar-wrapper  ">
			<div class="navbar-content scroll-div " >
				
				<div class="">
					<div class="main-menu-header">
						<img class="img-radius" src="../dist/assets/images/user/man.png" alt="User-Profile-Image">
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
							<li class="list-group-item"><a href="manager.php"><i class="feather icon-user m-r-5"></i>View Profile</a></li>
							<li class="list-group-item"><a href="modify_manager.php"><i class="feather icon-settings m-r-5"></i>Settings</a></li>
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
					    <a href="#" class="nav-link "><span class="pcoded-micon"><i class="feather icon-users"></i></span><span class="pcoded-mtext"> Members</span></a>
					    <ul class="pcoded-submenu">
					        <li><a href="users.php" class="nav-link ">Members Information</a></li>
					        <!-- <li><a href="#" class="nav-link">Horizontal</a></li> -->
					    </ul>
					</li>
					<li class="nav-item pcoded-hasmenu">
					    <a href="#" class="nav-link "><span class="pcoded-micon"><i class="feather icon-package"></i>
						</span><span class="pcoded-mtext">Packages</span></a>
					    <ul class="pcoded-submenu">
					        <li><a href="package.php" class="nav-link ">Add Package</a></li>
					        <li><a href="package_history.php" class="nav-link">Package History</a></li>
					    </ul>
					</li>
					<li class="nav-item pcoded-hasmenu">
					    <a href="#" class="nav-link "><span class="pcoded-micon"><i class="feather icon-credit-card"></i></span><span class="pcoded-mtext">Payments</span></a>
					    <ul class="pcoded-submenu">
					        <li><a href="viwe_payments.php" class="nav-link ">Viwe Payments</a></li>
					       <!-- <li><a href="payment_history.php" class="nav-link">Payment History</a></li> -->
					    </ul>
					</li>
					<li class="nav-item pcoded-hasmenu">
					    <a href="#" class="nav-link "><span class="pcoded-micon"><i class="feather icon-mic"></i></span><span class="pcoded-mtext">Announcement</span></a>
					    <ul class="pcoded-submenu">
					        <li><a href="announcement.php" class="nav-link ">Add Announcement</a></li>
					        <li><a href="announcement_history.php" class="nav-link">Announcement History</a></li>
					    </ul>
					</li>
					<li class="nav-item pcoded-hasmenu">
					    <a href="#" class="nav-link "><span class="pcoded-micon"><i class="feather icon-clipboard"></i></span><span class="pcoded-mtext">Workout Schedule</span></a>
					    <ul class="pcoded-submenu">
					        <li><a href="workout_schedule.php" class="nav-link ">Add Schedule</a></li>
					        <li><a href="schedule_history.php" class="nav-link">Schedule History</a></li>
					    </ul>
					</li>
				</ul>
				
			</div>
		</div>
	</nav>
	<!-- [ navigation menu ] end -->