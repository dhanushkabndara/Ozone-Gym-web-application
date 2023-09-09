<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php
// checking if a user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
}
$sn = 1;
$health_list = '';

// getting the list of user
$query = "SELECT * FROM user WHERE id = '$_SESSION[user_id]' LIMIT 1";
$lists = mysqli_query($connection, $query);

verify_query($lists);

while ($list = mysqli_fetch_assoc($lists)) {
    $health_list .= "<tr>";
    $health_list .= "<td>{$sn}</td>";
    $health_list .= "<td>{$list['first_name']}</td>";
    $health_list .= "<td>{$list['age']}</td>";
    $health_list .= "<td>{$list['gender']}</td>";
    $health_list .= "<td>{$list['body_type']}</td>";
    $health_list .= "<td>{$list['height']}</td>";
    $health_list .= "<td>{$list['weight']}</td>";
    $health_list .= "<td><a href=\"modify_hinfo.php?user_id={$list['id']}\"><button class=\"btn btn-success btn-sm\"><i class=\"feather mr-2 icon-edit\"></i>Update</button></a></td>";
    $health_list .= "</tr>";

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
                            <h5 class="m-b-10">Viwe Health Information</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Health History</a></li>
                            <li class="breadcrumb-item"><a href="#!">Health Information</a></li>
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
                            <span class="d-block m-t-5 font-weight-bold">Health Table</span>
                        </div>
                    </div>

                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm text-center">
                                <thead>
                                    <tr>
                                        <th>#S.No</th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Age</th>
                                        <th>Body Type</th>
                                        <th>Height</th>
                                        <th>Weight</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <?php echo $health_list; ?>
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