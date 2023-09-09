<?php session_start() ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
}

$announcement_list = '';

// getting the list of user
$query = "SELECT * FROM announcement WHERE active = 'YES' ";
$announcements = mysqli_query($connection, $query);

verify_query($announcements);

while ($announcement = mysqli_fetch_assoc($announcements)) {
    $announcement_list .= "<tr>";
    $announcement_list .= "<td>{$announcement['announcement']}</td>";
    $announcement_list .= "</tr>";

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
                            <h5 class="m-b-10">Dashboard</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="#!">Dashboard Announcement</a></li>
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

        <div class="col-xl-12">
            <h5 class="mt-4"></h5>
            <hr>
            <div class="row">
                <div class="col-sm-6">
                    <div class="card text-white bg-primary  text-center">
                        <div class="card-header font-weight-bold">
                            <h4 class="text-white"><i class="feather icon-bell"></i>&nbsp;Announcements</h4>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-white"><i class="feather icon-plus"></i>&nbsp;<?php echo $announcement_list; ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        <!-- [ Main Content ] end -->

<?php include 'footer.php'; ?>