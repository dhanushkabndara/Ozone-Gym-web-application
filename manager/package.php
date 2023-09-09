<?php session_start(); ?>
<?php require_once('../inc/connection.php'); ?>
<?php require_once('../inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: login.php');
	}

	$errors = array();
	$package_name = '';
	$package_dec = '';
	$validity = '';
    $amount = '';
    $action = '';


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


		if (empty($errors)) {
			// no errors found... adding new record
			$package_name = mysqli_real_escape_string($connection, $_POST['package_name']);
			$package_dec = mysqli_real_escape_string($connection, $_POST['package_dec']);
			$validity = mysqli_real_escape_string($connection, $_POST['validity']);
			$amount = mysqli_real_escape_string($connection, $_POST['amount']);
			$action = mysqli_real_escape_string($connection, $_POST['action']);

			$query = "INSERT INTO package ( ";
			$query .= "package_name, package_dec, validity, amount, active";
			$query .= ") VALUES (";
			$query .= "'{$package_name}', '{$package_dec}', '{$validity}', '{$amount}', '{$action}'";
			$query .= ")";

			$result = mysqli_query($connection, $query);

			if ($result) {
				// query successful... redirecting to users page
                $_SESSION['status'] = "Successfully Added New Package!. ";
				header('Location: package_history.php?package_added=true');
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
                            <h5 class="m-b-10">Add Package</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="#!">Add Package</a></li>
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
                    <div class="card-body">
                    <h5>Add  Package</h5>
                    <hr>
                    <?php 
                        if (!empty($errors)) {
                            display_errors($errors);
                        }
                    ?>
                        <form action="package.php" method="post">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="Text">Package Name</label>
                                        <input type="text" name="package_name" class="form-control" id="Text" placeholder="Package Name" >
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="Text">Duration</label>
                                        <input type="text" name="validity" class="form-control" id="Text" placeholder="Duration" >
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="text">Price</label>
                                        <input type="text" name="amount" class="form-control" id="amount" " placeholder="Rs 1000.00" >
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Package Description</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="package_dec"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Action</label>
                                        <select class="form-control" id="exampleFormControlSelect1" name="action">
									        <option value="">Select Action</option>
                                            <option value="active">Active</option>
                                            <option value="expire">Expire</option>
                                        </select>
                                    </div>
                                </div>
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