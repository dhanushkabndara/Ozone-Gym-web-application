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
$query = "SELECT * FROM package WHERE active = 'active' ";
$users = mysqli_query($connection, $query);

verify_query($users);

while ($user = mysqli_fetch_assoc($users)) {
    $package_list .= "<tr>";
    $package_list .= "<td>{$sn}</td>";
    $package_list .= "<td>{$user['package_name']}</td>";
    $package_list .= "<td>{$user['package_dec']}</td>";
    $package_list .= "<td>{$user['validity']}</td>";
    $package_list .= "<td>{$user['amount']}.00&nbsp;LKR</td>";
    $package_list .= "<td><span class=\"badge badge-light-success\"><i class=\"feather mr-2 icon-check-circle\"></i>&nbsp;{$user['active']}</span></td>";
    /**$package_list .= "<td><a href=\"payment.php?user_id={$_SESSION['user_id']}\" class=\"text-white\"><button class=\"btn btn-success btn-sm\"><span class=\"pcoded-micon\"><i class=\"feather icon-book\"></i><span class=\"pcoded-mtext\">&nbspBook</span></button></a></td>";*/
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
                            <h5 class="m-b-10">Viwe Packages</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Viwe Packages</a></li>
                            <li class="breadcrumb-item"><a href="#!">Packages List</a></li>
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
                        <span class="d-block m-t-5 font-weight-bold">All Packages</span>
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm text-center">
                                <thead>
                                    <tr>
                                        <th>#S.NO</th>
                                        <th>Package Name</th>
                                        <th>Package Description</th>
                                        <th>Validity</th>
                                        <th>Price</th>
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