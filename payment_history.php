<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php
// checking if a user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
}
$sn = 1;
$package_list = '';

// getting the list of user
$query = "SELECT p.*,py.* FROM payment p, package py WHERE p.u_id = '$_SESSION[user_id]' AND p.package_id = py.p_id ";
$lists = mysqli_query($connection, $query);

verify_query($lists);

while ($list = mysqli_fetch_assoc($lists)) {
    $package_list .= "<tr>";
    $package_list .= "<td>{$sn}</td>";
    $package_list .= "<td>{$list['package_name']}</td>";
    $package_list .= "<td>{$list['package_dec']}</td>";
    $package_list .= "<td>{$list['validity']}</td>";
    $package_list .= "<td>{$list['amount']}.00&nbsp;LKR</td>";
    $package_list .= "<td><span class=\"badge badge-light-success\"><i class=\"feather mr-2 icon-check-circle\"></i>&nbsp;{$list['status']}</span></td>";
    $package_list .= "</tr>";

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
                            <h5 class="m-b-10">Viwe Payments</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Payment History</a></li>
                            <li class="breadcrumb-item"><a href="#!">Payments</a></li>
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
                        <div class="contaner">
                            <span class="d-block m-t-5 font-weight-bold">Purchase Package</span>
                        </div>
                    </div>

                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm text-center">
                                <thead>
                                    <tr>
                                        <th>#S.No</th>
                                        <th>Package Name</th>
                                        <th>Package Descrption</th>
                                        <th>Package Validity</th>
                                        <th>Package Price</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <?php echo $package_list; ?>
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
</div>
<!-- [ Main Content ] end -->

<?php include 'footer.php'; ?>