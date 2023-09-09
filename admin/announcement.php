<?php session_start(); ?>
<?php require_once('../inc/connection.php'); ?>
<?php require_once('../inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: login.php');
	}

	$errors = array();
	$announcement = '';

	if (isset($_POST['submit'])) {
		
		$announcement = $_POST['announcement'];


		// checking required fields
		$req_fields = array('announcement');
		$errors = array_merge($errors, check_req_fields($req_fields));

		// checking max length
		$max_len_fields = array('announcement' => 250);
		$errors = array_merge($errors, check_max_len($max_len_fields));

		// checking email address
		/**if (!is_email($_POST['email'])) {
			$errors[] = 'Email address is invalid.';
		}*/

		// checking if email address already exists
		//$email = mysqli_real_escape_string($connection, $_POST['email']);
		//$query = "SELECT * FROM manager WHERE email = '{$email}' LIMIT 1";

		/**$result_set = mysqli_query($connection, $query);

		if ($result_set) {
			if (mysqli_num_rows($result_set) == 1) {
				$errors[] = 'Email address already exists';
			}
		}*/

		if (empty($errors)) {
			// no errors found... adding new record
			$announcement = mysqli_real_escape_string($connection, $_POST['announcement']);
			// email address is already sanitized
			$hashed_password = sha1($password);

			$query = "INSERT INTO announcement ( ";
			$query .= "announcement, active";
			$query .= ") VALUES (";
			$query .= "'{$announcement}', 'YES'";
			$query .= ")";

			$result = mysqli_query($connection, $query);

			if ($result) {
				// query successful... redirecting to users page
				header('Location: announcement.php?user_added=true');
			} else {
				$errors[] = 'Failed to add the new record.';
			}


		}



	}
 ?>
<?php include 'header.php'; ?>

	
	

<!-- [ Main Content ] start -->
<section class="pcoded-main-container">
    <div class="pcoded-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Announcement</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="#!">Add Announcement</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h5>Add  Announcement</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <form method="post">
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Text Here</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="announcement"></textarea>
                                    </div>
                                    <button type="submit" name="submit" class="btn  btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>

        </div>
</section>
<!-- [ Main Content ] end -->
<?php include 'footer.php'; ?>

