<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php
// checking if a user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
}
$sn = 1;
$user_list = '';

// getting the list of user
$query = "SELECT u.*, py.*, p.*, m.* FROM user u,payment py,package p, membership m WHERE u.id = m.u_id AND py.u_id = '$_SESSION[user_id]' AND p.p_id = py.package_id AND u.is_deleted=0 AND u.id = '$_SESSION[user_id]' ";
$users = mysqli_query($connection, $query);

verify_query($users);

while ($user = mysqli_fetch_assoc($users)) {
    if ($user['membership_status'] == 'Approved') {
        $user_list .= "<tr>";
        $user_list .= "<td>{$sn}</td>";
        $user_list .= "<td>{$user['first_name']}</td>";
        $user_list .= "<td>{$user['package_name']}</td>";
        $user_list .= "<td>{$user['package_dec']}</td>";
        $user_list .= "<td>{$user['validity']}</td>";
        $user_list .= "<td>{$user['start_date']}</td>";
        $user_list .= "<td>{$user['end_date']}</td>";
        $user_list .= "<td><span class=\"badge badge-light-success\"><i class=\"feather mr-2 icon-check-circle\"></i>&nbsp;{$user['membership_status']}</span></td>";
        //$user_list .= "<td><a href=\"modify_user.php?user_id={$user['id']}\" class=\"text-white\"><button class=\"btn btn-success mb-1\"><span class=\"pcoded-micon\"><i class=\"feather icon-edit\"></i><span class=\"pcoded-mtext\">&nbspEdit</span></a></button></a></td>";
        $user_list .= "</tr>";
    } else {
        $user_list .= "<tr>";
        $user_list .= "<td>{$sn}</td>";
        $user_list .= "<td>{$user['first_name']}</td>";
        $user_list .= "<td>{$user['package_name']}</td>";
        $user_list .= "<td>{$user['package_dec']}</td>";
        $user_list .= "<td>{$user['validity']}</td>";
        $user_list .= "<td>{$user['start_date']}</td>";
        $user_list .= "<td>{$user['end_date']}</td>";
        $user_list .= "<td><span class=\"badge badge-light-danger\"><i class=\"feather mr-2 icon-check-circle\"></i>&nbsp;{$user['membership_status']}</span></td>";
        //$user_list .= "<td><a href=\"modify_user.php?user_id={$user['id']}\" class=\"text-white\"><button class=\"btn btn-success mb-1\"><span class=\"pcoded-micon\"><i class=\"feather icon-edit\"></i><span class=\"pcoded-mtext\">&nbspEdit</span></a></button></a></td>";
        $user_list .= "</tr>";
    }
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
                            <h5 class="m-b-10">Viwe Membership</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Membership Information</a></li>
                            <li class="breadcrumb-item"><a href="#!">Membership</a></li>
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
                        <span class="d-block m-t-5 font-weight-bold">Membership</span>
                        <!-- <span class="d-block m-t-5">use class <code>table</code> inside table element</span> -->
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table id="table1" class="table table-bordered table-sm text-center">
                                <thead>
                                    <tr>
                                        <th>#S.NO</th>
                                        <th>Member Name</th>
                                        <th>Package Name</th>
                                        <th>Package Description</th>
                                        <th>Package Validation</th>
                                        <th>Membership Start</th>
                                        <th>Membership Expiration</th>
                                        <th>Membership Status</th>
                                    </tr>
                                </thead>
                                <?php echo $user_list; ?>
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
<?php $sn++; ?>
<script src="js/table.js"></script>
<?php include 'footer.php'; ?>