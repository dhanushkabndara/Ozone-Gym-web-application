<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	/**if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}*/
    
    
    $sn = 1;
	$package_list = '';

	// getting the list of user
	$query = "SELECT p.*,py.*,m.* FROM user m,package p,payment py WHERE p.p_id = py.package_id AND m.id = py.u_id AND py.status = 'paid' LIMIT 1";
	$lists = mysqli_query($connection, $query);

	verify_query($lists);

	while ($list = mysqli_fetch_assoc($lists)) {

        $_SESSION['amount'] = $list['amount'];
        $_SESSION['first_name'] = $list['first_name'];

		$package_list .= "<tr>";
        $package_list .= "<td>{$sn}</td>";
		$package_list .= "<td>{$list['package_name']}</td>";
		$package_list .= "<td>{$list['package_dec']}</td>";
        $package_list .= "<td>{$list['validity']}</td>";
        $package_list .= "<td>{$list['paid_date']}</td>";
        $package_list .= "<td>{$list['amount']}</td>";
		$package_list .= "</tr>";

        $sn++;
	}
 ?>





<!DOCTYPE html>
<html lang="en">
<head>
    <title>Ozone - Payment Invoice</title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="author" content="Phoenixcoded" />
    <!-- Favicon icon -->
    <link rel="icon" href="http://localhost/OzoneGym/dist/assets/images/favicon.ico" type="image/x-icon">

    <!-- vendor css -->
    <link rel="stylesheet" href="http://localhost/OzoneGym/dist/assets/css/style.css">
    
    

</head>
<body class="">

<!-- [ Main Content ] start -->
<section class="container">
    <div class="pcoded-content">
        <div class="container text-center">
            <h4><u>INVOICE</u></h4>
        </div>
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="page-header-title">
                            <h5 class="m-b-10">OZONE FITNESS</h5>
                            <h5 class="m-b-10">Address:No 26, Chilaw-Kurunegala Road, Barampola</h5>
                            <h5 class="m-b-10">Mobile: +94775893098</h5>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="page-header-title">
                            <img style="height: 10rem; width: 12rem; " src="http://localhost/OzoneGym/images/logo.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr class="d-inline-block" style="width: 100%;">
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        <div class="container">
            <!-- [ basic-table ] start -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Invoice Date:&nbsp;&nbsp;<?php echo date("d-m-y"); ?></h5></br>
                        <h5>Member Name:&nbsp;&nbsp;<?php echo $_SESSION['first_name'];?></h5></br>
                        <h5>Reg. Date:</h5>
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Package Name</th>
                                        <th>Package Description</th>
                                        <th>Duration</th>
                                        <th>Paid Date</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <?php echo $package_list; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ basic-table ] end -->
        </div>
        <div class="container text-right">
            <hr class="h-auto d-inline-block" style="width: 100%;">
            <h5>Total Rs:&nbsp;&nbsp;<?php echo $_SESSION['amount'] ?></h5>
            <hr class="h-auto d-inline-block" style="width: 100%;">
        </div>
        <!--<div>
        <a href=download_invoice.php><button class="btn btn-success btn-block mb-1">Print Invoice</button></a>
        </div>-->
        <!-- [ Main Content ] end -->
    </div>
</section>
<!-- [ Main Content ] end -->


    <!-- Required Js -->
    <script src="http://localhost/OzoneGym/dist/assets/js/vendor-all.min.js"></script>
    <script src="http://localhost/OzoneGym/dist/assets/js/plugins/bootstrap.min.js"></script>
    <script src="http://localhost/OzoneGym/dist/assets/js/pcoded.min.js"></script>



</body>
</html>
