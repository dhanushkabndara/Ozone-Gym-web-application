<?php session_start(); ?>
<?php require_once('../inc/connection.php'); ?>
<?php require_once('../inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: login.php');
	}

	$errors = array();
	$user_id = '';
	$first_name = '';
	$last_name = '';
	$email = '';

	if (isset($_GET['user_id'])) {
		// getting the user information
		$user_id = mysqli_real_escape_string($connection, $_GET['user_id']);
		$query = "SELECT * FROM manager WHERE m_id = {$user_id} LIMIT 1";

		$result_set = mysqli_query($connection, $query);

		if ($result_set) {
			if (mysqli_num_rows($result_set) == 1) {
				// user found
				$result = mysqli_fetch_assoc($result_set);
				$first_name = $result['first_name'];
				$last_name = $result['last_name'];
				$email = $result['email'];
			} else {
				// user not found
				header('Location: manager.php?err=user_not_found');	
			}
		} else {
			// query unsuccessful
			header('Location: manager.php?err=query_failed');
		}
	}

	if (isset($_POST['submit'])) {
		$user_id = $_POST['user_id'];
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$email = $_POST['email'];

		// checking required fields
		$req_fields = array('user_id', 'first_name', 'last_name', 'email');
		$errors = array_merge($errors, check_req_fields($req_fields));

		// checking max length
		$max_len_fields = array('first_name' => 50, 'last_name' =>100, 'email' => 100);
		$errors = array_merge($errors, check_max_len($max_len_fields));

		// checking email address
		if (!is_email($_POST['email'])) {
			$errors[] = 'Email address is invalid.';
		}

		// checking if email address already exists
		$email = mysqli_real_escape_string($connection, $_POST['email']);
		$query = "SELECT * FROM manager WHERE email = '{$email}' AND m_id != {$user_id} LIMIT 1";

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
			// email address is already sanitized

			$query = "UPDATE manager SET ";
			$query .= "first_name = '{$first_name}', ";
			$query .= "last_name = '{$last_name}', ";
			$query .= "email = '{$email}' ";
			$query .= "WHERE m_id = {$user_id} LIMIT 1";

			$result = mysqli_query($connection, $query);

			if ($result) {
				// query successful... redirecting to users page
				header('Location: manager.php?user_modified=true');
			} else {
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
                        <form method="post">
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
                                <!-- <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="Text">Text</label>
                                        <input type="text" name="" class="form-control" id="Text" placeholder="123">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="password">Password</label>
                                        <input type="password" name="Password" class="form-control" id="password" placeholder="Password">
                                    </div>
                                </div> -->
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
    
<?php include 'footer.php'; ?>