<?php session_start(); ?>
<?php require_once('../inc/connection.php'); ?>
<?php require_once('../inc/functions.php'); ?>
<?php
// checking if a user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
}
$sn = 1;
$payment_list = '';

// getting the list of user
$query = "SELECT p.*,py.*,u.* FROM package p, payment py,user u WHERE p.p_id = py.package_id AND py.u_id = u.id ORDER BY u.id ";
$get_lists = mysqli_query($connection, $query);

verify_query($get_lists);

while ($get_list = mysqli_fetch_assoc($get_lists)) {

    $payment_list .= "<tr>";
    $payment_list .= "<td>{$sn}</td>";
    $payment_list .= "<td>{$get_list['first_name']}</td>";
    $payment_list .= "<td>{$get_list['package_name']}</td>";
    $payment_list .= "<td>{$get_list['package_dec']}</td>";
    $payment_list .= "<td>{$get_list['validity']}</td>";
    $payment_list .= "<td>{$get_list['amount']}.00&nbsp;LKR</td>";
    $payment_list .= "<td><span class=\"badge badge-light-success\"><i class=\"feather mr-2 icon-check-circle\"></i>{$get_list['status']}</span></td>";
    $payment_list .= "<td><a href=\"modify_payments.php?user_id={$get_list['id']}\"><button class=\"btn btn-success btn-sm\"><i class=\"feather mr-2 icon-edit\"></i>Edit</button></a>&nbsp&nbsp<a href=\"delete_payments.php?user_id={$get_list['id']}\" 
        onclick=\"return confirm('Are you sure?');\"><button class=\"btn btn-danger btn-sm\"><i class=\"feather mr-2 icon-trash\"></i>Delete</button></a></td>";
    $payment_list .= "</tr>";

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
                            <h5 class="m-b-10">Payment Infromation</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="#!">Viwe Payments</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <!-- [ dismiss-alert ] start -->
        <?php
        if (isset($_SESSION['status'])) {

            if (($_SESSION['status']) == "Approved") {


                if (isset($_SESSION['status'])) {
                ?>
                    <div class="col-md-5">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong> <?php echo "Membership Approved!."; ?></strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                    </div>
                <?php
                    unset($_SESSION['status']);
                }
            } else {

                if (isset($_SESSION['status'])) {
                ?>
                    <div class="col-md-5">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong> <?php echo "Membership Rejected"; ?></strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                    </div>
                <?php
                    unset($_SESSION['status']);
                }
            }
        }
        ?>
        <!-- [ dismiss-alert ] end -->




        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ basic-table ] start -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <span class="d-block m-t-5">Members Payments</span>
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Package Name</th>
                                        <th>Package Description</th>
                                        <th>Duration</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <?php echo $payment_list; ?>
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