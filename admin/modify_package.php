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
	$package_name = '';
	$package_dec = '';
	$validity = '';
    $amount = '';
    $action = '';

	if (isset($_GET['user_id'])) {
		// getting the user information
		$user_id = mysqli_real_escape_string($connection, $_GET['user_id']);
		$query = "SELECT * FROM package WHERE p_id = {$user_id} LIMIT 1";

		$result_set = mysqli_query($connection, $query);

		if ($result_set) {
			if (mysqli_num_rows($result_set) == 1) {
				// user found
				$result = mysqli_fetch_assoc($result_set);
                $package_name = $result['package_name'];
                $package_dec = $result['package_dec'];
                $validity = $result['validity'];
                $amount = $result['amount'];
                $action = $result['active'];
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
		$package_name = $_POST['package_name'];
		$package_dec = $_POST['package_dec'];
		$validity = $_POST['validity'];
        $amount = $_POST['amount'];
		$action = $_POST['action'];

		// checking required fields
		$req_fields = array('package_name', 'package_dec', 'validity', 'amount', 'action');
		$errors = array_merge($errors, check_req_fields($req_fields));

		// checking max length
		$max_len_fields = array('package_name' => 20, 'package_dec' =>100, 'validity' => 20, 'amount' => 10, 'action' => 10);
		$errors = array_merge($errors, check_max_len($max_len_fields));

		// checking email address
		/**if (!is_email($_POST['email'])) {
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
		}*/

		if (empty($errors)) {
			// no errors found... adding new record
			$package_name = mysqli_real_escape_string($connection, $_POST['package_name']);
			$package_dec = mysqli_real_escape_string($connection, $_POST['package_dec']);
			$validity = mysqli_real_escape_string($connection, $_POST['validity']);
			$amount = mysqli_real_escape_string($connection, $_POST['amount']);
			$action = mysqli_real_escape_string($connection, $_POST['action']);
			// email address is already sanitized

			$query = "UPDATE package SET ";
			$query .= "package_name = '{$package_name}', ";
			$query .= "package_dec = '{$package_dec}', ";
			$query .= "validity = '{$validity}', ";
            $query .= "amount = '{$amount}', ";
            $query .= "active = '{$action}' ";
			$query .= "WHERE p_id = {$user_id} LIMIT 1";

			$result = mysqli_query($connection, $query);

			if ($result) {
				// query successful... redirecting to users page
				header('Location: package_history.php?user_modified=true');
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
                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                        <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="Text">Package Name</label>
                                        <input type="text" name="package_name" class="form-control" id="Text" placeholder="Package Name" <?php echo 'value="' . $package_name . '"'; ?>>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="Text">Duration</label>
                                        <input type="text" name="validity" class="form-control" id="Text" placeholder="Duration" <?php echo 'value="' . $validity . '"'; ?>>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="text">Price</label>
                                        <input type="text" name="amount" class="form-control" id="amount" " placeholder="Rs 1000.00" <?php echo 'value="' . $amount . '"'; ?>>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Package Description</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="package_dec" <?php echo 'value="' . $package_dec . '"'; ?>></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Action</label>
                                        <select class="form-control" id="exampleFormControlSelect1" name="action" <?php echo 'value="' . $action . '"'; ?>>
									        <option value="">Select Action</option>
                                            <option value="active">Active</option>
                                            <option value="expire">Expire</option>
                                        </select>
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
    
<?php include 'footer.php'; ?>