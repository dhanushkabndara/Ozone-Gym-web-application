<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>
<?php 
	// checking if a user is logged in
	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}

	$package_list = '';

	// getting the list of package
	$query = "SELECT * FROM package";
	$result_set = mysqli_query($connection, $query);

	verify_query($result_set);

	while ($result = mysqli_fetch_assoc($result_set)) {
        $package_list .= "<option value=\"{$result['p_id']}\">{$result['package_name']}</option";
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
                            <h5 class="m-b-10">Payment</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="#!"></a></li>
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
                    <div class="card-header">
                        <h4>Payment Method</h4>
                    </div>
                    <div class="card-body">
                        <?php 
                        if (!empty($errors)) {
                            display_errors($errors);
                            }
                        ?>
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="mt-2">Select Package</h5>
                                <hr>
                                <form>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Package</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="exampleFormControlSelect1" name="package">
                                                <?php echo $package_list; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Package description</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="exampleFormControlSelect1" name="gender">
									            <option value="">Select Gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Duration</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="exampleFormControlSelect1" name="packa">
									            <option value="">Select Gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Price</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="exampleFormControlSelect1" name="gender">
									            <option value="">Select Gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <h5 class="mt-2">Add Payment</h5>
                                <hr>
                                <form>
                                    <div class="form-group row">
                                        <label for="colFormLabel" class="col-sm-3 col-form-label">Card Holder Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="colFormLabel" placeholder="Card Holder Name">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="colFormLabel" class="col-sm-3 col-form-label">Credit Card Number</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="card_number" placeholder="**** **** **** 4296">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="colFormLabel" class="col-sm-3 col-form-label">Expiration</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control" id="card_exdate" placeholder="Exp. date">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="colFormLabel" class="col-sm-3 col-form-label">CVV</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="card_cvv" placeholder="CVV">
                                        </div>
                                    </div>
                                    <fieldset class="form-group">
                                        <div class="row">
                                            <label for="inputPassword3" class="col-sm-3 col-form-label">Select Card</label>
                                            <div class="col-sm-9">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1" checked>&nbsp
                                                    <label class="form-check-label" for="gridRadios1">Credit card &nbsp <img src="https://i.imgur.com/2ISgYja.png" width="22"></label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="option2">
                                                    &nbsp
                                                    <label class="form-check-label" for="gridRadios2">Debit card &nbsp<img src="https://i.imgur.com/W1vtnOV.png" width="22"></label>
                                                </div>
                                                <div class="form-check disabled">
                                                    <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios3" value="option3">
                                                    &nbsp
                                                    <label class="form-check-label" for="gridRadios3">Paypal &nbsp <img src="https://i.imgur.com/7kQEsHU.png" width="22"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                                <div class="form-group row">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn  btn-primary">Pay</button>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <!-- [ form-element ] start -->
    </div>
</div>
<!-- [ Main Content ] end -->
    
<?php include 'footer.php'; ?>

