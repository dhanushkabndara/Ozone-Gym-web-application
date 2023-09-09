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
$query = "SELECT u.*, s.* FROM user u, schedule s WHERE u.id = s.user_id AND status = 'active'";
$users = mysqli_query($connection, $query);

verify_query($users);

while ($user = mysqli_fetch_assoc($users)) {
    if ($user['status'] == 'active') {
        $user_list .= "<tr>";
        $user_list .= "<td>{$sn}</td>";
        $user_list .= "<td>{$user['s_name']}</td>";
        $user_list .= "<td>{$user['workout1']}</td>";
        $user_list .= "<td>{$user['workout2']}</td>";
        $user_list .= "<td>{$user['workout3']}</td>";
        $user_list .= "<td>{$user['workout4']}</td>";
        $user_list .= "<td>{$user['workout5']}</td>";
        $user_list .= "<td>{$user['workout6']}</td>";
        $user_list .= "<td>{$user['workout7']}</td>";
        $user_list .= "<td>{$user['workout8']}</td>";
        $user_list .= "<td>{$user['date']}</td>";
        $user_list .= "<td><span class=\"badge badge-light-success\"><i class=\"feather mr-2 icon-check-circle\"></i>&nbsp;{$user['status']}</span></td>";
        /**$user_list .= "<td><span class=\"badge badge-light-success\"><i class=\"feather mr-2 icon-check-circle\"></i>&nbsp;{$user['membership_status']}</span></td>";*/
        //$user_list .= "<td><a href=\"modify_user.php?user_id={$user['id']}\" class=\"text-white\"><button class=\"btn btn-success mb-1\"><span class=\"pcoded-micon\"><i class=\"feather icon-edit\"></i><span class=\"pcoded-mtext\">&nbspEdit</span></a></button></a></td>";
        $user_list .= "</tr>";
    } else {
        $user_list .= "<tr>";
        $user_list .= "<td>{$sn}</td>";
        $user_list .= "<td>{$user['s_name']}</td>";
        $user_list .= "<td>{$user['workout1']}</td>";
        $user_list .= "<td>{$user['workout2']}</td>";
        $user_list .= "<td>{$user['workout3']}</td>";
        $user_list .= "<td>{$user['workout4']}</td>";
        $user_list .= "<td>{$user['workout5']}</td>";
        $user_list .= "<td>{$user['workout6']}</td>";
        $user_list .= "<td>{$user['workout7']}</td>";
        $user_list .= "<td>{$user['workout8']}</td>";
        $user_list .= "<td>{$user['date']}</td>";
        $user_list .= "<td><span class=\"badge badge-light-danger\"><i class=\"feather mr-2 icon-check-circle\"></i>&nbsp;{$user['status']}</span></td>";
        /**$user_list .= "<td><span class=\"badge badge-light-danger\"><i class=\"feather mr-2 icon-check-circle\"></i>&nbsp;{$user['membership_status']}</span></td>";*/
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
                            <h5 class="m-b-10">Viwe Schedule</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Workout Schedule</a></li>
                            <li class="breadcrumb-item"><a href="#!">Schedule</a></li>
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
                        <span class="d-block m-t-5 font-weight-bold">Schedule</span>
                        <!-- <span class="d-block m-t-5">use class <code>table</code> inside table element</span> -->
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table id="table1" class="table table-bordered table-sm text-center">
                                <thead>
                                    <tr>
                                        <th>#S.NO</th>
                                        <th>Schedule Name</th>
                                        <th>Workout One</th>
                                        <th>Workout Two</th>
                                        <th>Workout Three</th>
                                        <th>Workout Four</th>
                                        <th>Workout Five</th>
                                        <th>Workout Six</th>
                                        <th>Workout Seven</th>
                                        <th>Workout Eight</th>
                                        <th>Workout Date</th>
                                        <th>Status</th>
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