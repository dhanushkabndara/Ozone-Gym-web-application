<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}

	$errors = array();
	$user_id = '';
	$first_name = '';
	$last_name = '';
	$email = '';
    $gender = '';
	$address = '';
	$tpnumber = '';

	if (isset($_SESSION['user_id'])) {
		// getting the user information
		$user_id = mysqli_real_escape_string($connection, $_SESSION['user_id']);
		$query = "SELECT * FROM user WHERE id = {$user_id} LIMIT 1";

		$result_set = mysqli_query($connection, $query);

		if ($result_set) {
			if (mysqli_num_rows($result_set) == 1) {
				// user found
				$result = mysqli_fetch_assoc($result_set);
				$first_name = $result['first_name'];
				$last_name = $result['last_name'];
				$email = $result['email'];
                $gender = $result['gender'];
				$address = $result['address'];
				$tpnumber = $result['tpnumber'];
			} else {
				// user not found
				header('Location: dashboard.php?err=user_not_found');	
			}
		} else {
			// query unsuccessful
			header('Location: dashboard.php?err=query_failed');
		}
	}

	if (isset($_POST['submit'])) {
		$user_id = $_POST['user_id'];
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$email = $_POST['email'];
        $email = $_POST['email'];
        $address = $_POST['address'];
		$tpnumber = $_POST['tpnumber'];

		// checking required fields
		$req_fields = array('user_id', 'first_name', 'last_name', 'email','gender','address','tpnumber' );
		$errors = array_merge($errors, check_req_fields($req_fields));

		// checking max length
		$max_len_fields = array('first_name' => 50, 'last_name' =>100, 'email' => 100,'gender' => 20,'address' => 100,'tpnumber' => 20);
		$errors = array_merge($errors, check_max_len($max_len_fields));

		// checking email address
		if (!is_email($_POST['email'])) {
			$errors[] = 'Email address is invalid.';
		}

		// checking if email address already exists
		$email = mysqli_real_escape_string($connection, $_POST['email']);
		$query = "SELECT * FROM user WHERE email = '{$email}' AND id != {$user_id} LIMIT 1";

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
			// email address is already sanitized

			$query = "UPDATE user SET ";
			$query .= "first_name = '{$first_name}', ";
			$query .= "last_name = '{$last_name}', ";
			$query .= "email = '{$email}', ";
            $query .= "gender = '{$gender}', ";
            $query .= "address = '{$address}', ";
            $query .= "tpnumber = '{$tpnumber}' ";
			$query .= "WHERE id = {$user_id} LIMIT 1";

			$result = mysqli_query($connection, $query);

			if ($result) {
				// query successful... redirecting to users page
				$_SESSION['status'] = "Successfully User Infromation Changed! ";
				header('Location: dashboard.php?user_modified=true');
			} else {
                $_SESSION['status'] = "Faild to Change User Infromation! ";
				$errors[] = 'Failed to modify the record.';
			}
		}
	}
?>
<?php include 'header.php'; ?>

	
	

<!-- [ Main Content ] start -->
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Profile Infromation</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Modify User</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <!-- <div class="card-header">
                        <h5>Basic Component</h5>
                    </div> -->
                    <div class="card-body">
                    <?php 
                        if (!empty($errors)) {
                            display_errors($errors);
                        }
                    ?>
                        <form action="user.php" method="post">
                            <div class="row">
                                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="Text">First Name</label>
                                        <input type="text" name="first_name" class="form-control" id="Text" placeholder="First Name" <?php echo 'value="' . $first_name . '"'; ?>>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="Text">Last Name</label>
                                        <input type="text" name="last_name" class="form-control" id="Text" placeholder="Last Name" <?php echo 'value="' . $last_name . '"'; ?>>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="Email">Email address</label>
                                        <input type="email" name="email" class="form-control" id="Email" aria-describedby="emailHelp" placeholder="Email" <?php echo 'value="' . $email . '"'; ?>>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="Text">Gender</label>
                                        <input type="text" name="gender" class="form-control" id="Text" placeholder="Gender" <?php echo 'value="' . $gender . '"'; ?>>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="Text">Address</label>
                                        <input type="text" name="address" class="form-control" id="Text" placeholder="Address" <?php echo 'value="' . $address . '"'; ?>>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="Text">Telephone Number</label>
                                        <input type="text" name="tpnumber" class="form-control" id="Text" placeholder="Telephone Number" <?php echo 'value="' . $tpnumber . '"'; ?>>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="submit" class="btn  btn-primary">Change</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
            <!-- [ form-element ] start -->

    </div>
</div>
<!-- [ Main Content ] end -->
    
    <!-- Warning Section Ends -->
<?php include 'footer.php'; ?>