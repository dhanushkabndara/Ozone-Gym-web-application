<?php session_start(); ?>
<?php require_once('../inc/connection.php'); ?>
<?php require_once('../inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: login.php');
	}

	$user_list = '';

	// getting the list of user
	$query = "SELECT * FROM manager WHERE is_deleted=0 AND m_id = '$_SESSION[user_id]' ";
	$users = mysqli_query($connection, $query);

	verify_query($users);

	while ($user = mysqli_fetch_assoc($users)) {
		$user_list .= "<tr>";
        $user_list .= "<td>{$user['m_id']}</td>";
		$user_list .= "<td>{$user['first_name']}</td>";
		$user_list .= "<td>{$user['last_name']}</td>";
        $user_list .= "<td>{$user['email']}</td>";
		$user_list .= "<td>{$user['last_login']}</td>";
		$user_list .= "<td><a href=\"modify_manager.php?user_id={$user['m_id']}\">Edit</a>&nbsp&nbsp<a href=\"delete_manager.php?user_id={$user['m_id']}\" 
        onclick=\"return confirm('Are you sure?');\">Delete</a></td>";
		//$user_list .= "<td><a href=\"delete_user.php?user_id={$user['id']}\" 
						//onclick=\"return confirm('Are you sure?');\">Delete</a></td>";
		$user_list .= "</tr>";
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
                            <h5 class="m-b-10">Manager Infromation</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Viwe Manager</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ basic-table ] start -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <!-- <h5>Basic Table</h5> -->
                        <!-- <span class="d-block m-t-5">use class <code>table</code> inside table element</span> -->
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Last Login</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <?php echo $user_list; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ basic-table ] end -->
    </div>
</div>
<!-- [ Main Content ] end -->
    
<?php include 'footer.php'; ?>

