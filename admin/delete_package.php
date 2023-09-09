<?php session_start(); ?>
<?php require_once('../inc/connection.php'); ?>
<?php require_once('../inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: login.php');
	}

	if (isset($_GET['user_id'])) {
		// getting the user information
		$user_id = mysqli_real_escape_string($connection, $_GET['user_id']);

			// deleting the user
			$query = "UPDATE package SET active = 'expire' WHERE p_id = {$user_id} LIMIT 1";

			$result = mysqli_query($connection, $query);

			if ($result) {
				// user deleted
				$_SESSION['status'] = "Successfully Package Deleted!. ";
				header('Location: package_history.php?msg=user_deleted');
			} else {
				$_SESSION['status'] = "Package Delete Unnccessfull!. ";
				header('Location: package_history.php?err=delete_failed');
			}
		
		
	} else {
		header('Location: package_history.php');
	}
?>