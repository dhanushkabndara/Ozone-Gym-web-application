<?php session_start(); ?>
<?php require_once('../inc/connection.php'); ?>
<?php require_once('../inc/functions.php'); ?>
<?php 
	// checking if a announcement is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: login.php');
	}

	$announcement_list = '';

	// getting the list of user
	$query = "SELECT * FROM announcement WHERE active = 'YES' ORDER BY a_id";
	$announcements = mysqli_query($connection, $query);

	verify_query($announcements);

	while ($announcement = mysqli_fetch_assoc($announcements)) {
		$announcement_list .= "<tr>";
        $announcement_list .= "<td>{$announcement['a_id']}</td>";
		$announcement_list .= "<td>{$announcement['announcement']}</td>";
		$announcement_list .= "<td>{$announcement['active']}</td>";
		$announcement_list .= "<td><a href=\"modify_announcement.php?announcement_id={$announcement['a_id']}\" class=\"text-white\"><button class=\"btn btn-success btn-sm\"><span class=\"pcoded-micon\"><i class=\"feather icon-edit\"></i><span class=\"pcoded-mtext\">&nbspEdit</span></a></button>&nbsp&nbsp<a href=\"delete_announcement.php?announcement_id={$announcement['a_id']}\" 
        onclick=\"return confirm('Are you sure?');\" class=\"text-white\"><button class=\"btn btn-danger btn-sm\"><span class=\"pcoded-micon\"><i class=\"feather icon-trash\"></i><span class=\"pcoded-mtext\">&nbspDelete</span></a></button></td>";
		/**$announcement_list .= "<td><a href=\"delete_announcement.php?announcement_id={$announcement['id']}\" 
						//onclick=\"return confirm('Are you sure?');\" class=\"text-white\"><button class=\"btn btn-danger mb-1\"><span class=\"pcoded-micon\"><i class=\"feather icon-trash\"></i><span class=\"pcoded-mtext\">Delete</span></a></button></td>";*/
		$announcement_list .= "</tr>";
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
                            <h5 class="m-b-10">Announcement</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="#!">Announcement History</a></li>
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
                        <span class="d-block m-t-5">Announcement Table</span> 
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Announcement</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <?php echo $announcement_list; ?>
                            </table>
                            <nav aria-label="Page navigation example">
							    <ul class="pagination justify-content-end">
								    <li class="page-item disabled">
									    <a class="page-link" href="#!" tabindex="-1">Previous</a>
								    </li>
								    <li class="page-item"><a class="page-link" href="#!">1</a></li>
								    <li class="page-item"><a class="page-link" href="#!">2</a></li>
								    <li class="page-item"><a class="page-link" href="#!">3</a></li>
								    <li class="page-item">
									<a class="page-link" href="#!">Next</a>
								    </li>
							    </ul>
						    </nav>
                        </div>
                    </div>
                </div>
            </div>
        <!-- [ basic-table ] end -->
    </div>
</div>
<!-- [ Main Content ] end -->
   
<?php include 'footer.php'; ?>

