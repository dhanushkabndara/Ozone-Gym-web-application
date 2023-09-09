<?php session_start() ?>
<?php require_once('../inc/connection.php'); ?>
<?php require_once('../inc/functions.php'); ?>
<?php
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
}

$user_count = '';
$announcement_count = '';
$package_count = '';
$total_income = 0;

// getting the list of user
$user_query = "SELECT id FROM user WHERE is_deleted=0 ORDER BY id";
$users = mysqli_query($connection, $user_query);

$user_count = mysqli_num_rows($users);

// getting the list of announcements
$announcement_query = "SELECT a_id FROM announcement WHERE active = 'YES' ORDER BY a_id";
$announcements = mysqli_query($connection, $announcement_query);

$announcement_count = mysqli_num_rows($announcements);

// getting the list of packages
$package_query = "SELECT p_id FROM package WHERE active = 'active' ORDER BY p_id";
$packages = mysqli_query($connection, $package_query);

$package_count = mysqli_num_rows($packages);

// getting the list of amount
$amount_query = "SELECT p.*,pack.* FROM package pack, payment p WHERE p_id = package_id ORDER BY p.payment_id ";
$amount = mysqli_query($connection, $amount_query);

verify_query($amount);

while ($amounts = mysqli_fetch_assoc($amount)) {

    $total_income = $total_income + $amounts['amount'];
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
                            <h5 class="m-b-10">Dashboard Analytics</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Dashboard Analytics</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <!-- table card-1 start -->
        <div class="col-md-12 col-xl-18">
            <div class="card flat-card">
                <div class="row-table">
                    <div class="col-sm-6 card-body br">
                        <div class="row">
                            <div class="col-sm-4">
                                <i class="icon feather icon-users text-c-green mb-1 d-block"></i>
                            </div>
                            <div class="col-sm-8 text-md-center">
                                <h5><?php echo $user_count; ?></h5>
                                <span>Total Registerd Users</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 card-body br">
                        <div class="row">
                            <div class="col-sm-4">
                                <i class="icon feather icon-credit-card text-c-red mb-1 d-block"></i>
                            </div>
                            <div class="col-sm-8 text-md-center">
                                <h5><?php echo $total_income; ?>.00&nbsp;LKR</h5>
                                <span>Total Income</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 card-body br">
                        <div class="row">
                            <div class="col-sm-4">
                                <i class="icon feather icon-mic text-c-blue mb-1 d-block"></i>
                            </div>
                            <div class="col-sm-8 text-md-center">
                                <h5><?php echo $announcement_count; ?></h5>
                                <span>Announcements</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <i class="icon feather icon-box text-c-yellow mb-1 d-block"></i>
                            </div>
                            <div class="col-sm-8 text-md-center">
                                <h5><?php echo $package_count; ?></h5>
                                <span>Packages</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- table card-1 end -->
    </div>
</div>
<!-- [ Main Content ] end -->

<?php include 'footer.php'; ?>