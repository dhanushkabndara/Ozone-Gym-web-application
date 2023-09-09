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
$query = "SELECT * FROM user WHERE is_deleted=0 ORDER BY id";
$users = mysqli_query($connection, $query);

verify_query($users);

while ($user = mysqli_fetch_assoc($users)) {
    $user_list .= "<tr>";
    $user_list .= "<td>{$sn}</td>";
    $user_list .= "<td>{$user['first_name']}</td>";
    $user_list .= "<td>{$user['gender']}</td>";
    $user_list .= "<td>{$user['body_type']}</td>";
    $user_list .= "<td>{$user['age']}</td>";
    $user_list .= "<td>{$user['height']}</td>";
    $user_list .= "<td>{$user['weight']}</td>";
    $user_list .= "<td><a href=\"add_schedule.php?user_id={$user['id']}\" class=\"text-white\"><button class=\"btn btn-success btn-sm\"><span class=\"pcoded-micon\"><i class=\"feather icon-edit\"></i><span class=\"pcoded-mtext\">&nbspAdd</span></a></button></td>";
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
                            <li class="breadcrumb-item"><a href="#!">Schedule Information</a></li>
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
                        <span class="d-block m-t-5">Workout Schedule</span>
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm text-center">
                                <thead>
                                    <tr>
                                        <th>#S.No</th>
                                        <th>First Name</th>
                                        <th>Gender</th>
                                        <th>Body Type</th>
                                        <th>Age</th>
                                        <th>Height</th>
                                        <th>Weight</th>
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