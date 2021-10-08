<!DOCTYPE html>
<html lang="en">

<?php
include('header.php');
?>

<?php
//prevent user from coming to reset page if there is no email or token in url
if (!isset($_GET['email']) && !isset($_GET['token'])) {
    redirect("index.php");
} else {
    if (isset($_POST['reset_submit'])) {
        //we have to make sure that the information we are receiving from the email belongs to the right user
        $email = $_GET['email']; //from url
        $token = $_GET['token']; //from url
        $stmt = query("SELECT username,user_email,token FROM users WHERE token='{$token}'");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //check if the token and email from url match the correct user in database
        if (($_GET['token'] !== $row['token']) && ($_GET['email'] !== $row['user_email'])) {
            redirect("index.php");
        }

        $password = validate($_POST['password']);
        $password_repeat = validate($_POST['password_repeat']);
        $password_size = strlen($password);

        //CHECKING FOR ERRORS
        if (empty($password) || empty($password_repeat)) {
            redirect("reset.php?error=emptyFields");
            exit();
        } elseif ($password_size <= 4) {
            //check if length of password is valid
            redirect("reset.php?error=invalid_pwd_length");
            exit();
        } elseif ($password !== $password_repeat) {
            //check if password are same
            redirect("reset.php?error=pwd_no_match");
            exit();
        }

        //updating password and token columns
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $token_update = "Token used";  //once we are done using the token, we don't want it anymore

        $stmt = prepare_query("UPDATE users SET user_password=?,token=? WHERE user_email=?");
        $stmt->bindParam(1, $passwordHash, PDO::PARAM_STR);
        $stmt->bindParam(2, $token_update, PDO::PARAM_STR);
        $stmt->bindParam(3, $email, PDO::PARAM_STR);
        $stmt->execute();
        unset($stmt);

        redirect("login.php?success=reset");
    }
}

?>

<section class="ftco-section">

    <div class="container">


        <div class="row">
            <div class="col-xl-10 ftco-animate">
            
                <!-- Display error messages -->
                <?php display_error_message(); ?>

                <!-- Display success messages -->
                <?php display_success_message(); ?>

                <form action="" method="post" class="p-3 billing-form ftco-bg-dark p-md-5">
                    <h3 style="text-align:center" class="mb-4 billing-heading">Reset Password</h3>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Enter new password">
                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="password">Repeat New Password</label>
                            <input type="password" class="form-control" name="password_repeat" placeholder="repeat new password">
                        </div>
                    </div>


                    <div class="row justify-content-center">
                        <div class="form-group">
                            <button type="submit" name="reset_submit" class="btn btn-primary btn-lg">LOG IN</button>
                        </div>
                    </div>
                    <br>

                    <input type="hidden" class="hide" name="token" id="token" value="">

                </form>

            </div>

        </div>
    </div>
</section>


<?php
include('footer.php');
?>



<div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
        <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
        <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00" />
    </svg></div>
<script src="js/jquery.min.js"></script>
<script src="js/jquery-migrate-3.0.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.easing.1.3.js"></script>
<script src="js/jquery.waypoints.min.js"></script>
<script src="js/jquery.stellar.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/aos.js"></script>
<script src="js/jquery.animateNumber.min.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/jquery.timepicker.min.js"></script>
<script src="js/scrollax.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&amp;sensor=false"></script>
<script src="js/google-map.js"></script>
<script src="js/main.js"></script>
<script>
    $(document).ready(function() {

        var quantitiy = 0;
        $('.quantity-right-plus').click(function(e) {

            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            var quantity = parseInt($('#quantity').val());

            // If is not undefined

            $('#quantity').val(quantity + 1);


            // Increment

        });

        $('.quantity-left-minus').click(function(e) {
            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            var quantity = parseInt($('#quantity').val());

            // If is not undefined

            // Increment
            if (quantity > 0) {
                $('#quantity').val(quantity - 1);
            }
        });

    });
</script>

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-23581568-13');
</script>
</body>

<!-- Mirrored from preview.colorlib.com/theme/coffeeblend/checkout.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 18 Apr 2021 16:32:50 GMT -->

</html>



<?php
//close database connection - initialize object to null
$pdo = null;
ob_end_flush();
?>