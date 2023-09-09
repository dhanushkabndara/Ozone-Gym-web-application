<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php
// checking if a user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
}

$errors = array();
$package_id = '';
$package_desc = '';
$package_validity = '';
$package_amount = '';
$card_owner_name = '';
$card_number = '';
$card_expiration = '';
$card_cvv = '';
$card_type = '';


if (isset($_POST['submit'])) {

    $package_id = $_POST['package_id'];
    $package_desc = $_POST['package_desc'];
    $package_validity = $_POST['package_validity'];
    $package_amount = $_POST['package_amount'];
    $card_owner_name = $_POST['card_owner_name'];
    $card_number = $_POST['card_number'];
    $card_expiration = $_POST['card_expiration'];
    $card_cvv = $_POST['card_cvv'];
    $card_type = $_POST['card_type'];


    // checking required fields
    $req_fields = array('package_id', 'package_desc', 'package_validity', 'package_amount', 'card_owner_name', 'card_number', 'card_expiration', 'card_cvv', 'card_type');
    $errors = array_merge($errors, check_req_fields($req_fields));

    // checking max length
    $max_len_fields = array('package_id' => 40, 'package_desc' => 100, 'package_validity' => 40, 'package_amount' => 10, 'card_owner_name' => 100, 'card_number' => 20, 'card_expiration' => 40, 'card_cvv' => 4, 'card_type' => 20);
    $errors = array_merge($errors, check_max_len($max_len_fields));


    if (empty($errors)) {
        // no errors found... adding new record
        $package_id = mysqli_real_escape_string($connection, $_POST['package_id']);
        $package_desc = mysqli_real_escape_string($connection, $_POST['package_desc']);
        $package_validity = mysqli_real_escape_string($connection, $_POST['package_validity']);
        $package_amount = mysqli_real_escape_string($connection, $_POST['package_amount']);
        $card_owner_name = mysqli_real_escape_string($connection, $_POST['card_owner_name']);
        $card_number = mysqli_real_escape_string($connection, $_POST['card_number']);
        $card_expiration = mysqli_real_escape_string($connection, $_POST['card_expiration']);
        $card_cvv = mysqli_real_escape_string($connection, $_POST['card_cvv']);
        $card_type = mysqli_real_escape_string($connection, $_POST['card_type']);

        //is already sanitized


        $query = "INSERT INTO payment ( ";
        $query .= "package_id, package_desc, package_validity, package_amount, card_owner_name, card_number, card_expiration, card_cvv, card_type, u_id, status";
        $query .= ") VALUES (";
        $query .= "'{$package_id}', '{$package_desc}', '{$package_validity}', '{$package_amount}', '{$card_owner_name}', '{$card_number}', '{$card_expiration}', '{$card_cvv}', '{$card_type}',{$_SESSION['user_id']}, 'Paid'";
        $query .= ")";

        $result = mysqli_query($connection, $query);

        if ($result) {
            // query successful... redirecting to users page

            $email = '';
            $name = '';
            $amount = '';
            $validity = '';

            // getting the list of package
            $query = "SELECT u.*, py.*, pack.* FROM user u, payment py, package pack where py.package_id = $package_id AND u.id = '$_SESSION[user_id]'";
            $result_set = mysqli_query($connection, $query);

            verify_query($result_set);

            while ($result = mysqli_fetch_assoc($result_set)) {
                $email = $result['email'];
                $name = $result['first_name'];
                $amount = $result['amount'];
                $validity = $result['validity'];
            }

            // <-- email Start -->
            $date = date("Y-m-d h:i:sa");

            $to           = $email;
            $mail_subject  = 'Ozone - Payment has been successfully Paid!';
            $email_body    = "<b style=\"font-size: 12px; color:#000\">Dear Sir/Madam,</b><br>";
            $email_body   .= "<br>";
            $email_body   .= "<b>{$name}, This is remider that your package have been successfully purchased.</b><br>";
            $email_body   .= "<br>";
            $email_body   .= "<b><strong>Payments Information</strong></b><br>";
            $email_body   .= "<hr style=\"width:100%\">";
            $email_body   .= "<br>";
            $email_body   .= "<b>Date and Time:{$date}</b><br>";
            $email_body   .= "<b>Total Payment:{$amount}.00</b>LKR<br>";
            $email_body   .= "<b>Package Valid Period:{$validity}</b><br>";
            $email_body   .= "<br>";
            $email_body   .= "<b>Thank you!, Plase do not replay this mail,as this is an automated mail.</b><br>";
            $email_body   .= "<br>";
            $email_body   .= "<b>Best regards,</b><br>";
            $email_body   .= "<b>Ozone Fitness Center.</b><br>";


            $header       = "From: {$email}\r\nContent-Type: text/html;";

            $send_mail_result = mail($to, $mail_subject, $email_body, $header);

            if ($send_mail_result) {
                $_SESSION['status'] = "Successfully Purchased Package!. ";
                header('Location: payment_history.php?payment_added=true');
            } else {
                $_SESSION['status'] = "Faild to Purchased Package!. ";
                header('Location: payment_history.php?payment_added=false');
            }
            // <-- email End -->

        } else {
            $errors[] = 'Failed to add the new record.';
        }
    }
}

$package_list = '';

// getting the list of package
$query = "SELECT * FROM package where active = 'active'";
$result_set = mysqli_query($connection, $query);

verify_query($result_set);

while ($result = mysqli_fetch_assoc($result_set)) {
    $package_list .= "<option value=\"{$result['p_id']}\">{$result['package_name']}</option>";
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
                            <h5 class="m-b-10">Payments</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Add Payment</a></li>
                            <li class="breadcrumb-item"><a href="#!">Payments</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <!-- [ dismiss-alert ] start -->
        <?php
        if (!empty($errors)) {
        ?>
            <div class="col-md-4">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>
                        <?php
                        display_errors($errors);
                        ?>
                    </strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
            </div>
        <?php

        }
        ?>
        <!-- [ dismiss-alert ] end -->



        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <span class="d-block m-t-5 font-weight-bold">Payment Method</span>
                    </div>
                    <div class="card-body">

                        <form action="payment.php" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="mt-2 font-weight-bold">Select Package</h6>
                                    <hr>

                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Package</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="package_id" name="package_id">
                                                <option>Select Package</option>
                                                <?php echo $package_list; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Package description</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="package_dec" name="package_desc">

                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Duration</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="validity" name="package_validity">

                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Price LKR</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="amount" name="package_amount">

                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <h6 class="mt-2 font-weight-bold">Add Payment</h6>
                                    <hr>

                                    <div class="form-group row">
                                        <label for="colFormLabel" class="col-sm-3 col-form-label">Card Holder Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="card_owner_name" class="form-control" id="colFormLabel" placeholder="Card Holder Name" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="colFormLabel" class="col-sm-3 col-form-label">Credit Card Number</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="card_number" class="form-control" id="card_number" placeholder="**** **** **** 4296" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="colFormLabel" class="col-sm-3 col-form-label">Expiration</label>
                                        <div class="col-sm-9">
                                            <input type="date" name="card_expiration" class="form-control" id="card_exdate" placeholder="Exp. date" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="colFormLabel" class="col-sm-3 col-form-label">CVV</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="card_cvv" class="form-control" id="card_cvv" placeholder="CVV" required>
                                        </div>
                                    </div>
                                    <fieldset class="form-group">
                                        <div class="row">
                                            <label for="inputPassword3" class="col-sm-3 col-form-label">Select Card Type</label>
                                            <div class="col-sm-9">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="card_type" id="gridRadios1" value="master card" checked>&nbsp
                                                    <label class="form-check-label" for="gridRadios1">Credit card &nbsp <img src="https://i.imgur.com/2ISgYja.png" width="22"></label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="card_type" id="gridRadios2" value="visa card">
                                                    &nbsp
                                                    <label class="form-check-label" for="gridRadios2">Debit card &nbsp<img src="https://i.imgur.com/W1vtnOV.png" width="22"></label>
                                                </div>
                                                <div class="form-check disabled">
                                                    <input class="form-check-input" type="radio" name="card_type" id="gridRadios3" value="paypal">
                                                    &nbsp
                                                    <label class="form-check-label" for="gridRadios3">Paypal &nbsp <img src="https://i.imgur.com/7kQEsHU.png" width="22"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <button type="submit" name="submit" class="btn  btn-success">
                                                <span class="pcoded-micon"><i class="feather icon-arrow-right"></i><span class="pcoded-mtext">&nbspPay Now</span></a>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ form-element ] start -->
    </div>
</div>
<!-- [ Main Content ] end -->
<!-- [ Dropdown List Content ] start -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $("#package_id").on("change", function() {
            var packageId = $("#package_id").val();
            var getURL = "get_pdesc.php?p_id=" + packageId;
            $.get(getURL, function(data, status) {
                $("#package_dec").html(data);
            });
        });

        $("#package_id").on("change", function() {
            var validityId = $("#package_id").val();
            var getURL = "get_validity.php?p_id=" + validityId;
            $.get(getURL, function(data, status) {
                $("#validity").html(data);
            });
        });
        $("#package_id").on("change", function() {
            var priceId = $("#package_id").val();
            var getURL = "get_price.php?p_id=" + priceId;
            $.get(getURL, function(data, status) {
                $("#amount").html(data);
            });
        });
    });
</script>
<!-- [ Dropdown List Content ] end -->

<?php include 'footer.php'; ?>