<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}

    $errors = array();

	if (isset($_POST['submit'])) {
		$user_id = $_POST['user_id'];
		$new_password = $_POST['new_password'];
		$conform_new_password = $_POST['conform_new_password'];

		// checking required fields
		$req_fields = array('user_id', 'new_password', 'conform_new_password' );
		$errors = array_merge($errors, check_req_fields($req_fields));

		// checking max length
		$max_len_fields = array('new_password' => 40, 'conform_new_password' => 40);
		$errors = array_merge($errors, check_max_len($max_len_fields));

		// checking email address
		if (($new_password) != ($conform_new_password)) {
			$errors[] = ' Password is not matched.';
		}

		if (empty($errors)) {
			// no errors found... adding new record
            $password = mysqli_real_escape_string($connection, $_POST['new_password']);
            $hashed_password = sha1($password);

			$query = "UPDATE user SET ";
			$query .= "password = '{$hashed_password}' ";
			$query .= "WHERE id = {$user_id} LIMIT 1";


			$result = mysqli_query($connection, $query);

			if ($result) {
				// query successful... redirecting to users page
                $_SESSION['status'] = "Successfully Password Changed! ";
				header('Location: dashboard.php?user_modified=true');
			} else {
                $_SESSION['status'] = "Faild to Rest Password! ";
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
                            <h5 class="m-b-10">Profile Settings</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Rest User Password</a></li>
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
                        <form action="settings.php" method="post">
                            <div class="row">
                                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="password">Password</label>
                                        <input type="password" name="new_password" class="form-control" id="password" placeholder="********">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="password">Password</label>
                                        <input type="password" name="conform_new_password" class="form-control" id="password" placeholder="********">
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