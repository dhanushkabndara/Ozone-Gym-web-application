<?php session_start() ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php
    if(!isset($_SESSION['user_id'])){
        header('Location: index.php');
    }

    $sn = 1;
	$user_list = '';
    $name = '';
    $price = '';

	// getting the list of user
	$query = "SELECT p.*,py.* FROM package p,payment py WHERE p.p_id = py.package_id AND py.u_id = '$_SESSION[user_id]' AND py.status = 'paid' ";
	$users = mysqli_query($connection, $query);

	verify_query($users);

	while ($user = mysqli_fetch_assoc($users)) {

        $_SESSION['amount'] = $user['amount'];
        $_SESSION['user_id'] = $user['u_id'];

        $price = $user['amount'];

		$user_list .= "<tr>";
        $user_list .= "<td>{$sn}</td>";
		$user_list .= "<td>{$user['package_name']}</td>";
		$user_list .= "<td>{$user['package_dec']}</td>";
        $user_list .= "<td>{$user['validity']}</td>";
        $user_list .= "<td>{$user['paid_date']}</td>";
        $user_list .= "<td>{$user['amount']}.00&nbsp;LKR</td>";
		$user_list .= "</tr>";

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
                            <h5 class="m-b-10">Viwe Invoice</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Viwe Invoice</a></li>
                            <li class="breadcrumb-item"><a href="#!">Invoice</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <div class="container">
            <div class="row justify-content-end">
                <?php
                    $query = "SELECT py.* FROM payment p, package py WHERE p.u_id = '$_SESSION[user_id]' ";
                    $users = mysqli_query($connection, $query);

                    echo "<a href=\"download_invoice.php?user_id={$_SESSION['user_id']}\" class=\"text-white\"><button class=\"btn btn-danger mb-1\"><span class=\"pcoded-micon\"><i class=\"feather icon-download\"></i><span class=\"pcoded-mtext\">&nbspPrint Invoice</span></a>";
                ?>
             </div>
        </div>       

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
                            <img style="height: 10rem; width: 12rem; " src="images/logo.png">
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
                        <h5>Invoice Date: <?php echo date("d-m-y"); ?></h5></br>
                        <h5>Member Name: <?php echo $_SESSION['first_name'];?></h5></br>
                        <h5>Reg. Date:</h5>
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table text-center">
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
                                <?php echo $user_list; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ basic-table ] end -->
        </div>
        <div class="container">
            <div class="text-right">
                <hr class="h-auto d-inline-block" style="width: 100%;">
                <h5>Total Rs: <?php echo $price; ?>.00&nbsp;LKR</h5>
                <hr class="h-auto d-inline-block" style="width: 100%;">
            </div>
        </div>

        <!-- [ Main Content ] end -->
    </div>
</section>
<!-- [ Main Content ] end -->
    
<?php include 'footer.php'; ?>

