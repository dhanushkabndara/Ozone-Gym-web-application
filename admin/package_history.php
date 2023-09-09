<?php session_start(); ?>
<?php require_once('../inc/connection.php'); ?>
<?php require_once('../inc/functions.php'); ?>
<?php
// checking if a user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
}
$sn = 1;
$package_list = '';

// getting the list of user
$query = "SELECT * FROM package WHERE active = 'active' ORDER BY p_id";
$packages = mysqli_query($connection, $query);

verify_query($packages);

while ($list = mysqli_fetch_assoc($packages)) {
    $package_list .= "<tr>";
    $package_list .= "<td>{$sn}</td>";
    $package_list .= "<td>{$list['package_name']}</td>";
    $package_list .= "<td>{$list['package_dec']}</td>";
    $package_list .= "<td>{$list['validity']}</td>";
    $package_list .= "<td>{$list['amount']}.00&nbsp;LKR</td>";
    $package_list .= "<td><span class=\"badge badge-light-success\"><i class=\"feather mr-2 icon-check-circle\"></i>{$list['active']}</span></td>";
    $package_list .= "<td><a href=\"modify_package.php?user_id={$list['p_id']}\" class=\"text-white\"><button class=\"btn btn-success btn-sm\"><span class=\"pcoded-micon\"><i class=\"feather icon-edit\"></i><span class=\"pcoded-mtext\">&nbspEdit</span></button></a>&nbsp&nbsp<a href=\"delete_package.php?user_id={$list['p_id']}\" 
        onclick=\"return confirm('Are you sure?');\" class=\"text-white\"><button class=\"btn btn-danger btn-sm\"><span class=\"pcoded-micon\"><i class=\"feather icon-trash\"></i><span class=\"pcoded-mtext\">&nbspDelete</span></button></a></td>";
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
                            <h5 class="m-b-10">Packages Infromation</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="#!">Viwe Package History</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <!-- [Star Alert] -->
        <?php
        if (isset($_SESSION['status'])) {
        ?>
            <div class="col-md-5 alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                    <use xlink:href="#check-circle-fill" />
                </svg>
                <div class="mt-2">
                    <?php
                    echo $_SESSION['status'];
                    ?>
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        <?php
            unset($_SESSION['status']);
        }
        ?>

        <?php
        if (isset($errors) && !empty($errors)) {
        ?>
            <div class="col-md-5 alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                    <use xlink:href="#check-circle-fill" />
                </svg>
                <div class="mt-2">
                    <?php
                    echo '<p class="error">Invalid Username / Password!</p>';
                    ?>
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        <?php
        }
        ?>

        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ basic-table ] start -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <span class="d-block m-t-5">Package Table</span>
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Package Name</th>
                                        <th>package Description</th>
                                        <th>Duration</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Action</th>
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
    <!-- [ Main Content ] end -->

    <?php include 'footer.php'; ?>