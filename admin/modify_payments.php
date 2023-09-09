<?php session_start(); ?>
<?php require_once('../inc/connection.php'); ?>
<?php require_once('../inc/functions.php'); ?>
<?php
// checking if a user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
}

$errors = array();
$user_id = '';
$name = '';
$email = '';
$validity = '';


if (isset($_GET['user_id'])) {
    // getting the user information
    $user_id = mysqli_real_escape_string($connection, $_GET['user_id']);
    $query = "SELECT u.*,p.*,pack.* FROM user u, payment p, package pack WHERE p.package_id = pack.p_id AND u.id = {$user_id} LIMIT 1";

    $result_set = mysqli_query($connection, $query);

    if ($result_set) {
        if (mysqli_num_rows($result_set) == 1) {
            // user found
            $result = mysqli_fetch_assoc($result_set);
            $name = $result['first_name'];
            $email = $result['email'];
            $validity = $result['validity'];
        } else {
            // user not found
            header('Location: users.php?err=user_not_found');
        }
    } else {
        // query unsuccessful
        header('Location: users.php?err=query_failed');
    }
}


if (isset($_POST['submit'])) {
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $validity = $_POST['validity'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $approval = $_POST['approval'];

    // checking required fields
    $req_fields = array('user_id', 'start_date', 'end_date', 'approval');
    $errors = array_merge($errors, check_req_fields($req_fields));

    // checking max length
    $max_len_fields = array('start_date' => 20, 'end_date' => 20, 'approval' => 20);
    $errors = array_merge($errors, check_max_len($max_len_fields));

    if (empty($errors)) {
        // no errors found... adding new record
        $start_date = mysqli_real_escape_string($connection, $_POST['start_date']);
        $end_date = mysqli_real_escape_string($connection, $_POST['end_date']);
        $approval = mysqli_real_escape_string($connection, $_POST['approval']);

        if (($approval) == "Approved") {

            // email address is already sanitized

            $query = "INSERT INTO membership ( ";
            $query .= "start_date, end_date, u_id, membership_status";
            $query .= ") VALUES (";
            $query .= "'{$start_date}', '{$end_date}', '{$user_id}', '{$approval}'";
            $query .= ")";

            $result = mysqli_query($connection, $query);

            if ($result) {
                // query successful... redirecting to users page

                // <-- email Start -->
                $date = date("Y-m-d h:i:sa");

                $to           = $email;
                $mail_subject  = 'Ozone - Membership has been successfully Approved!';
                $email_body    = "<b style=\"font-size: 12px; color:#000\">Dear Sir/Madam,</b><br>";
                $email_body   .= "<br>";
                $email_body   .= "<b>{$name}, This is remider that your membership have been successfully Approved.</b><br>";
                $email_body   .= "<br>";
                $email_body   .= "<b><strong>Membership Information</strong></b><br>";
                $email_body   .= "<hr style=\"width:100%\">";
                $email_body   .= "<br>";
                $email_body   .= "<b>Membership Validate Period:{$validity}</b><br>";
                $email_body   .= "<b>Membership Start Date:{$start_date}</b><br>";
                $email_body   .= "<b>Membership Expire Date:{$end_date}</b><br>";
                $email_body   .= "<br>";
                $email_body   .= "<b>Thank you!, Plase do not replay this mail,as this is an automated mail.</b><br>";
                $email_body   .= "<br>";
                $email_body   .= "<b>Best regards,</b><br>";
                $email_body   .= "<b>Ozone Fitness Center.</b><br>";


                $header       = "From: {$email}\r\nContent-Type: text/html;";

                $send_mail_result = mail($to, $mail_subject, $email_body, $header);

                if ($send_mail_result) {
                    $_SESSION['status'] = "Approved";
                    header('Location: viwe_payments.php?membership_approved=true');
                } else {
                    $_SESSION['status'] = "Rejected";
                    header('Location: viwe_payments.php?membership_approved=false');
                }
                // <-- email End -->

            } else {
                $errors[] = 'Failed to modify the record.';
            }
        } else {
            // email address is already sanitized

            $query = "INSERT INTO membership ( ";
            $query .= "start_date, end_date, u_id, membership_status";
            $query .= ") VALUES (";
            $query .= "'null', 'null', '{$user_id}', '{$approval}'";
            $query .= ")";

            $result = mysqli_query($connection, $query);

            if ($result) {
                // query successful... redirecting to users page

                // <-- email Start -->
                $date = date("Y-m-d h:i:sa");

                $to           = $email;
                $mail_subject  = 'Ozone - Membership has been Rejected!';
                $email_body    = "<b style=\"font-size: 12px; color:#000\">Dear Sir/Madam,</b><br>";
                $email_body   .= "<br>";
                $email_body   .= "<b>{$name}, This is remider that your membership have been Rejected because your payment unsuccessfull.</b><br>";
                $email_body   .= "<br>";
                $email_body   .= "<b><strong>Membership Information</strong></b><br>";
                $email_body   .= "<hr style=\"width:100%\">";
                $email_body   .= "<br>";
                $email_body   .= "<br>";
                $email_body   .= "<b>Thank you!, Plase do not replay this mail,as this is an automated mail.</b><br>";
                $email_body   .= "<br>";
                $email_body   .= "<b>Best regards,</b><br>";
                $email_body   .= "<b>Ozone Fitness Center.</b><br>";


                $header       = "From: {$email}\r\nContent-Type: text/html;";

                $send_mail_result = mail($to, $mail_subject, $email_body, $header);

                if ($send_mail_result) {
                    $_SESSION['status'] = "Rejected";
                    header('Location: viwe_payments.php?membership_rejected=true');
                } else {
                    $_SESSION['status'] = "Rejected";
                    header('Location: viwe_payments.php?membership_rejected=false');
                }
                // <-- email End -->

            } else {
                $errors[] = 'Failed to modify the record.';
            }
        }
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
                            <h5 class="m-b-10">Membership Approval</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">User Membership</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <!-- <div class="card-header">
                        <h5>Basic Component</h5>
                    </div> -->
                    <div class="card-body">
                        <?php
                        if (!empty($errors)) {
                            display_errors($errors);
                        }
                        ?>
                        <form action="modify_payments.php" method="post">
                            <div class="row">
                                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                <input type="hidden" name="name" value="<?php echo $name; ?>">
                                <input type="hidden" name="email" value="<?php echo $email; ?>">
                                <input type="hidden" name="validity" value="<?php echo $validity; ?>">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="Text">Start Date</label>
                                        <input type="date" name="start_date" class="form-control" id="Text">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="Text">End Date</label>
                                        <input type="date" name="end_date" class="form-control" id="Text">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="Text">Membership Approval</label>
                                        <select class="form-control" id="exampleFormControlSelect1" name="approval" required>
                                            <option value="">Select Options</option>
                                            <option value="Approved">Approved</option>
                                            <option value="Rejected">Rejected</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="submit" class="btn  btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ form-element ] start -->

    </div>
</div>
<!-- [ Main Content ] end -->

<?php include 'footer.php'; ?>