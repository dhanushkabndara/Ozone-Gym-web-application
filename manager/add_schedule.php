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
	/**$first_name = '';
	$last_name = '';
	$email = '';
    $gender = '';
	$address = '';
	$tpnumber = '';*/

	if (isset($_GET['user_id'])) {
		// getting the user information
		$user_id = mysqli_real_escape_string($connection, $_GET['user_id']);
		$query = "SELECT * FROM user WHERE id = {$user_id} LIMIT 1";

		$result_set = mysqli_query($connection, $query);

		if ($result_set) {
			if (mysqli_num_rows($result_set) == 1) {
				// user found
				$result = mysqli_fetch_assoc($result_set);
				/**$first_name = $result['first_name'];
				$last_name = $result['last_name'];
				$email = $result['email'];
                $gender = $result['gender'];
				$address = $result['address'];
				$tpnumber = $result['tpnumber'];*/
			} else {
				// user not found
				header('Location: users.php?err=user_not_found');	
			}
		} else {
			// query unsuccessful
			header('Location: users.php?err=query_failed');
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

			$query = "INSERT INTO schedule ( ";
			$query .= "s_name, workout1, workout2, workout3, workout4, workout5, workout6, workout7, workout8, date, user_id, status";
			$query .= ") VALUES (";
			$query .= "'{$schedule_name}', '{$workout_one}', '{$workout_two}', '{$workout_three}', '{$workout_four}', '{$workout_five}', '{$workout_six}', '{$workout_seven}', '{$workout_eight}', '{$workout_date}', '{$user_id}', 'active'";
			$query .= ")";

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
                                        <label class="floating-label" for="Text">Schedule Name</label>
                                        <input type="text" name="schedule_name" class="form-control" id="Text" placeholder="Schedule Name">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="Text">Workout One</label>
                                        <input type="text" name="w1" class="form-control" id="Text" placeholder="Workout One">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="Email">Workout Two</label>
                                        <input type="text" name="w2" class="form-control" id="Email" aria-describedby="emailHelp" placeholder="Workout Two">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="Text">Workout Three</label>
                                        <input type="text" name="w3" class="form-control" id="Text" placeholder="Workout Three">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="Text">Workout Four</label>
                                        <input type="text" name="w4" class="form-control" id="Text" placeholder="Workout Four">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="Email">Workout Five</label>
                                        <input type="text" name="w5" class="form-control" id="tpnumber" placeholder="Workout Five">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="Text">Workout Six</label>
                                        <input type="text" name="w6" class="form-control" id="Text" placeholder="Workout Six">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="Text">Workout Seven</label>
                                        <input type="text" name="w7" class="form-control" id="Text" placeholder="Workout Seven">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="Text">Workout Eight</label>
                                        <input type="text" name="w8" class="form-control" id="Text" placeholder="Workout Eight">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="Text">Workout Date</label>
                                        <input type="date" name="date" class="form-control" id="Text" placeholder="Workout Date">
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
                            <button type="submit" name="submit" class="btn  btn-primary">Add</button>
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