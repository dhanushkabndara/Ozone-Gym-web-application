<?php session_start(); ?>
<?php require_once('../inc/connection.php'); ?>
<?php require_once('../inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}

	$errors = array();
	$user_id = '';
    $member_name = '';
    $schedule_name = '';
    $workout_one = '';
    $workout_two = '';
    $workout_three = '';
    $workout_four = '';
    $workout_five = '';
    $workout_six = '';
    $workout_seven = '';
    $workout_eight = '';
    $workout_date = '';

	if (isset($_GET['user_id'])) {
		// getting the user information
		$user_id = mysqli_real_escape_string($connection, $_GET['user_id']);
		$query = "SELECT u.*, s.* FROM user u, schedule s WHERE u.id = s.user_id AND user_id = {$user_id} LIMIT 1";

		$result_set = mysqli_query($connection, $query);

		if ($result_set) {
			if (mysqli_num_rows($result_set) == 1) {
				// user found
				$result = mysqli_fetch_assoc($result_set);
                $member_name = $result['first_name'];
                $schedule_name = $result['s_name'];
                $workout_one = $result['workout1'];
                $workout_two = $result['workout2'];
                $workout_three = $result['workout3'];
                $workout_four = $result['workout4'];
                $workout_five = $result['workout5'];
                $workout_six = $result['workout6'];
                $workout_seven = $result['workout7'];
                $workout_eight = $result['workout8'];
                $workout_date = $result['date'];
			} else {
				// user not found
				header('Location: schedule_history.php?err=user_not_found');	
			}
		} else {
			// query unsuccessful
			header('Location: schedule_history.php?err=query_failed');
		}
	}

	if (isset($_POST['submit'])) {
		$user_id = $_POST['user_id'];
		$schedule_name = $_POST['schedule_name'];
		$workout_one = $_POST['w1'];
        $workout_two = $_POST['w2'];
        $workout_three = $_POST['w3'];
        $workout_four = $_POST['w4'];
        $workout_five = $_POST['w5'];
        $workout_six = $_POST['w6'];
        $workout_seven = $_POST['w7'];
        $workout_eight = $_POST['w8'];
		$workout_date = $_POST['date'];

		// checking required fields
		$req_fields = array('user_id', 'schedule_name', 'w1', 'w2','w3','w4','w5','w6','w7','w8','date' );
		$errors = array_merge($errors, check_req_fields($req_fields));

		// checking max length
		$max_len_fields = array('schedule_name' => 50, 'w1' =>20, 'w2' => 20,'w3' => 20,'w4' => 20,'w5' => 20,'w6' => 20 ,'w7' => 20 ,'w8' => 20 );
		$errors = array_merge($errors, check_max_len($max_len_fields));


		if (empty($errors)) {
			// no errors found... adding new record
			$schedule_name = mysqli_real_escape_string($connection, $_POST['schedule_name']);
            $workout_one = mysqli_real_escape_string($connection, $_POST['w1']);
			$workout_two = mysqli_real_escape_string($connection, $_POST['w2']);
			$workout_three = mysqli_real_escape_string($connection, $_POST['w3']);
            $workout_four = mysqli_real_escape_string($connection, $_POST['w4']);
            $workout_five = mysqli_real_escape_string($connection, $_POST['w5']);
            $workout_six = mysqli_real_escape_string($connection, $_POST['w6']);
            $workout_seven = mysqli_real_escape_string($connection, $_POST['w7']);
            $workout_eight = mysqli_real_escape_string($connection, $_POST['w8']);
            $workout_date = mysqli_real_escape_string($connection, $_POST['date']);
			// email address is already sanitized

			$query = "UPDATE schedule SET ";
			$query .= "s_name = '{$schedule_name}', ";
			$query .= "workout1 = '{$workout_one}', ";
			$query .= "workout2 = '{$workout_two}', ";
            $query .= "workout3 = '{$workout_three}', ";
            $query .= "workout4 = '{$workout_four}', ";
            $query .= "workout5 = '{$workout_five}', ";
            $query .= "workout6 = '{$workout_six}', ";
            $query .= "workout7 = '{$workout_seven}', ";
            $query .= "workout8 = '{$workout_eight}', ";
            $query .= "date = '{$workout_date}' ";
			$query .= "WHERE user_id = {$user_id} LIMIT 1";

			$result = mysqli_query($connection, $query);

			if ($result) {
				// query successful... redirecting to users page
                $_SESSION['status'] = "Successfully Information Updated!. ";
				header('Location: schedule_history.php?user_modified=true');
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
                            <h5 class="m-b-10">Schedule Infromation</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Modify Member Schedule</a></li>
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
                                <input type="hidden" name="member_name" value="<?php echo $member_name; ?>">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="Text">Schedule Name</label>
                                        <input type="text" name="schedule_name" class="form-control" id="Text" placeholder="Schedule Name" <?php echo 'value="' . $schedule_name . '"'; ?>>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="Text">Workout One</label>
                                        <input type="text" name="w1" class="form-control" id="Text" placeholder="Workout One" <?php echo 'value="' . $workout_one . '"'; ?>>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="Email">Workout Two</label>
                                        <input type="text" name="w2" class="form-control" id="Email" aria-describedby="emailHelp" placeholder="Workout Two" <?php echo 'value="' . $workout_two . '"'; ?>>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="Text">Workout Three</label>
                                        <input type="text" name="w3" class="form-control" id="Text" placeholder="Workout Three" <?php echo 'value="' . $workout_three . '"'; ?>>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="Text">Workout Four</label>
                                        <input type="text" name="w4" class="form-control" id="Text" placeholder="Workout Four" <?php echo 'value="' . $workout_four . '"'; ?>>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="Email">Workout Five</label>
                                        <input type="text" name="w5" class="form-control" id="tpnumber" placeholder="Workout Five" <?php echo 'value="' . $workout_five . '"'; ?>>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="Text">Workout Six</label>
                                        <input type="text" name="w6" class="form-control" id="Text" placeholder="Workout Six" <?php echo 'value="' . $workout_six . '"'; ?>>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="Text">Workout Seven</label>
                                        <input type="text" name="w7" class="form-control" id="Text" placeholder="Workout Seven" <?php echo 'value="' . $workout_seven . '"'; ?>>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="Text">Workout Eight</label>
                                        <input type="text" name="w8" class="form-control" id="Text" placeholder="Workout Eight" <?php echo 'value="' . $workout_eight . '"'; ?>>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="Text">Workout Date</label>
                                        <input type="date" name="date" class="form-control" id="Text" placeholder="Workout Date" <?php echo 'value="' . $workout_date . '"'; ?>>
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