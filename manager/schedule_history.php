<?php session_start(); ?>
<?php require_once('../inc/connection.php'); ?>
<?php require_once('../inc/functions.php'); ?>
<?php
// checking if a user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
}
$sn = 1;
$user_list = '';

// getting the list of user
$query = "SELECT s.*, u.* FROM schedule s, user u WHERE s.user_id = u.id AND status ='active' ORDER BY schedule_id";
$users = mysqli_query($connection, $query);

verify_query($users);

while ($user = mysqli_fetch_assoc($users)) {
    $user_list .= "<tr>";
    $user_list .= "<td>{$sn}</td>";
    $user_list .= "<td>{$user['first_name']}</td>";
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
    $user_list .= "<td>{$user['status']}</td>";
    $user_list .= "<td><a href=\"modify_schedule.php?user_id={$user['id']}\" class=\"text-white\"><button class=\"btn btn-success btn-sm\"><span class=\"pcoded-micon\"><i class=\"feather icon-edit\"></i><span class=\"pcoded-mtext\">&nbspEdit</span></a></button>&nbsp&nbsp<a href=\"delete_schedule.php?user_id={$user['id']}\" 
        onclick=\"return confirm('Are you sure?');\" class=\"text-white\"><button class=\"btn btn-danger btn-sm\"><span class=\"pcoded-micon\"><i class=\"feather icon-trash\"></i><span class=\"pcoded-mtext\">&nbspDelete</span></a></button></td>";
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
                            <h5 class="m-b-10">Schedule Infromation</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="#!">Schedule History</a></li>
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
                        <span class="d-block m-t-5">Schedule Table</span>
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm text-center">
                                <thead>
                                    <tr>
                                        <th>#S.No</th>
                                        <th>Member Name</th>
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
                                        <th>Action</th>
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
    <!-- [ Main Content ] end -->

    <?php include 'footer.php'; ?>