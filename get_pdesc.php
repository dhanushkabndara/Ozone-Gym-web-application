<?php require_once('inc/connection.php'); ?>
<?php

	if ( isset($_GET['p_id']) ) {

		$p_id = mysqli_real_escape_string($connection, $_GET['p_id']);

		$query 		= "SELECT * FROM package WHERE p_id = {$p_id}";
		$result_set = mysqli_query($connection, $query);

		$pdesc_list = "";
		while ( $result = mysqli_fetch_assoc($result_set) ) {
			$pdesc_list .= "<option value=\"{$result['p_id']}\">{$result['package_dec']}</option>";
		}
		echo $pdesc_list;
	} else {
		echo "<option>Error</option>";
	}

	
?>
