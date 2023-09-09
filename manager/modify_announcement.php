<?php session_start(); ?>
<?php require_once('../inc/connection.php'); ?>
<?php require_once('../inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: login.php');
	}

	$errors = array();
	$announcement_id = '';
	$announcement = '';


	if (isset($_GET['announcement_id'])) {
		// getting the user information
		$announcement_id = mysqli_real_escape_string($connection, $_GET['announcement_id']);
		$query = "SELECT * FROM announcement WHERE a_id = {$announcement_id} LIMIT 1";

		$result_set = mysqli_query($connection, $query);

		if ($result_set) {
			if (mysqli_num_rows($result_set) == 1) {
				// user found
				$result = mysqli_fetch_assoc($result_set);
				$announcement = $result['announcement'];

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
		$announcement_id = $_POST['announcement_id'];
		$announcement = $_POST['announcement'];

		// checking required fields
		$req_fields = array('announcement_id', 'announcement');
		$errors = array_merge($errors, check_req_fields($req_fields));

		// checking max length
		$max_len_fields = array('announcement' =>100);
		$errors = array_merge($errors, check_max_len($max_len_fields));

		if (empty($errors)) {
			// no errors found... adding new record
			$announcement = mysqli_real_escape_string($connection, $_POST['announcement']);


			$query = "UPDATE announcement SET ";
			$query .= "announcement = '{$announcement}' ";
			$query .= "WHERE a_id = {$announcement_id} LIMIT 1";

			$result = mysqli_query($connection, $query);

			if ($result) {
				// query successful... redirecting to users page
				header('Location: announcement_history.php?announcement_modified=true');
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
                            <h5 class="m-b-10">Announcement Infromation</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Modify announcement</a></li>
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
                                <input type="hidden" name="announcement_id" value="<?php echo $announcement_id; ?>">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="Text">Announcement</label>
                                        <input type="text" name="announcement" class="form-control" id="Text" placeholder="announcement" <?php echo 'value="' . $announcement . '"'; ?>>
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