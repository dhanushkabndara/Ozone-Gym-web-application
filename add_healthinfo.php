<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php
// checking if a user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
}

$errors = array();
$user_id = '';
/**$first_name = '';
$last_name = '';
$email = '';
$gender = '';
$address = '';
$tpnumber = '';*/

if (isset($_SESSION['user_id'])) {
    // getting the user information
    $user_id = mysqli_real_escape_string($connection, $_SESSION['user_id']);
    $query = "SELECT * FROM user WHERE id = {$user_id} LIMIT 1";

    $result_set = mysqli_query($connection, $query);

    if ($result_set) {
        if (mysqli_num_rows($result_set) == 1) {
            // user found
            $result = mysqli_fetch_assoc($result_set);
            /**$first_name = $result['first_name'];
            $last_name = $result['last_name'];
            $email = $result['email'];
            $gender = $result['gender'];
            $address = $result['address'];
            $tpnumber = $result['tpnumber'];*/
        } else {
            // user not found
            header('Location: dashboard.php?err=user_not_found');
        }
    } else {
        // query unsuccessful
        header('Location: dashboard.php?err=query_failed');
    }
}

if (isset($_POST['submit'])) {
    $user_id = $_POST['user_id'];
    $body_type = $_POST['body_type'];
    $age = $_POST['age'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];


    // checking required fields
    $req_fields = array('user_id', 'body_type', 'age', 'height', 'weight');
    $errors = array_merge($errors, check_req_fields($req_fields));

    // checking max length
    $max_len_fields = array('body_type' => 50, 'age' => 20, 'height' => 20, 'weight' => 20);
    $errors = array_merge($errors, check_max_len($max_len_fields));


    if (empty($errors)) {
        // no errors found... adding new record
        $body_type = mysqli_real_escape_string($connection, $_POST['body_type']);
        $age = mysqli_real_escape_string($connection, $_POST['age']);
        $height = mysqli_real_escape_string($connection, $_POST['height']);
        $weight = mysqli_real_escape_string($connection, $_POST['weight']);
        // email address is already sanitized

        $query = "UPDATE user SET ";
        $query .= "body_type = '{$body_type}', ";
        $query .= "age = '{$age}', ";
        $query .= "height = '{$height}', ";
        $query .= "weight = '{$weight}' ";
        $query .= "WHERE id = {$user_id} LIMIT 1";

        $result = mysqli_query($connection, $query);

        if ($result) {
            // query successful... redirecting to users page
            $_SESSION['status'] = "Successfully Health Infromation Changed! ";
            header('Location: view_healthinfo.php?user_modified=true');
        } else {
            $_SESSION['status'] = "Faild to Change User Infromation! ";
            $errors[] = 'Failed to modify the record.';
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
                            <h5 class="m-b-10">Health Infromation</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i>&nbsp;/&nbsp; Health Information</a></li>
                            <li class="breadcrumb-item"><a href="#!">Add Health Infromation</a></li>
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
                        <form action="add_healthinfo.php" method="post">
                            <div class="row">
                                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="Text">Body Type</label>
                                        <select class="form-control" id="exampleFormControlSelect1" name="body_type" required>
                                            <option value="">Select Body Type</option>
                                            <option value="ectomorph">ECTOMORPH BODY</option>
                                            <option value="mesomorph">MESOMORPH BODY</option>
                                            <option value="endomorph">ENDOMORPH BODY</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="Text">Age</label>
                                        <input type="text" name="age" class="form-control" id="Text" placeholder="Age">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="Text">Height</label>
                                        <input type="text" name="height" class="form-control" id="Text" placeholder="Body Height">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="floating-label" for="Text">Weight</label>
                                        <input type="text" name="weight" class="form-control" id="Text" placeholder="Body Weight">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="submit" class="btn  btn-primary">Add</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ form-element ] start -->

    </div>
</div>
<!-- [ Main Content ] end -->

<!-- Warning Section Ends -->
<?php include 'footer.php'; ?>