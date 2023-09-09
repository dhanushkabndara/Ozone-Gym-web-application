<?php session_start(); ?>
<?php require_once('../inc/connection.php'); ?>
<?php require_once('../inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: login.php');
	}
    $sn = 1;
	$session_list = '';

	// getting the list of user
	$query = "SELECT * FROM user WHERE is_deleted = '0' ORDER BY id ";
	$get_lists = mysqli_query($connection, $query);

	verify_query($get_lists);

	while ($get_list = mysqli_fetch_assoc($get_lists)) {

		$session_list .= "<tr>";
        $session_list .= "<td>{$sn}</td>";
        $session_list .= "<td>{$get_list['first_name']}</td>";
        $session_list .= "<td>{$get_list['last_name']}</td>";
		$session_list .= "<td>{$get_list['gender']}</td>";
		$session_list .= "<td>{$get_list['last_login']}</td>";
		$session_list .= "</tr>";

        $sn++;
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
                            <h5 class="m-b-10">Members Sessions</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="#!">Members Sessions</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <!-- [ dismiss-alert ] start -->
        <?php
        if (isset($_SESSION['status'])) {
        ?>

            <div class="col-md-5">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong> <?php echo $_SESSION['status']; ?></strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
            </div>
        <?php
            unset($_SESSION['status']);
        }
        ?>
        <!-- [ dismiss-alert ] end -->




        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ basic-table ] start -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <span class="d-block m-t-5">Members Sessions Logins</span> 
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm text-center">
                                <thead>
                                    <tr>
                                        <th>#S.NO</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Gender</th>
                                        <th>Last Login</th>
                                    </tr>
                                </thead>
                                <?php echo $session_list; ?>
                            </table>
                        </div>
                    </div>
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
        <!-- [ basic-table ] end -->
    </div>
</div>
<!-- [ Main Content ] end -->
    
<?php include 'footer.php'; ?>

