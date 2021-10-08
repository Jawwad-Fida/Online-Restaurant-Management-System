<!DOCTYPE html>
<html lang="en">

<?php
include('header.php');
?>

<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
include(__DIR__ . "/vendor/autoload.php");
?>


<!-- Mail Section (Mailtrap API) -->
<?php
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load(); //works here

//Mailtrap Credentials
$SMTP_HOST = getenv('SMTP_HOST');
$SMTP_PORT = getenv('SMTP_PORT');
$SMTP_USER = getenv('SMTP_USER');
$SMTP_PASSWORD = getenv('SMTP_PASSWORD');
$SMTP_ENCRYPTION = PHPMailer::ENCRYPTION_STARTTLS;
$mail = new PHPMailer(true);
//echo get_class($mail); //find out if class is available
?>

<?php

if (isset($_POST['forgot_submit'])) {
    $email = validate($_POST['email']);

    //Error messages
    if (empty($email)) {
        redirect("forgot.php?error=emptyFields");
        exit();
    }

    //check if email exists
    if (email_does_not_exist($email) == 'true') {
        redirect("forgot.php?error=no_email");
        exit();
    }

    //Creating tokens (see if same system can be used for OTP order and reservation - part 2)
    $length = 50;
    $token = bin2hex(openssl_random_pseudo_bytes($length));

    //Updating database with token values
    $stmt = prepare_query("UPDATE users SET token=? WHERE user_email=?");
    $stmt->bindParam(1, $token, PDO::PARAM_STR);
    $stmt->bindParam(2, $email, PDO::PARAM_STR);
    $stmt->execute();
    unset($stmt); //close off prepared statements

    //Setting up PHP Mailer for Mailtrap API
    try {
        //access class

        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                   
        $mail->isSMTP();
        $mail->Host = $SMTP_HOST;
        $mail->Username = $SMTP_USER;
        $mail->Password = $SMTP_PASSWORD;
        $mail->Port = $SMTP_PORT;
        $mail->SMTPSecure = $SMTP_ENCRYPTION;
        $mail->SMTPAuth = true;

        //Recipients
        $mail->setFrom('admin@example.com', 'Restaurant Admin');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Email';
        $mail->Body = "<p>Please click here to reset your password: - 
        <a href='http://www.jawwadfida.com/phpDemo/food/reset.php?email={$email}&token={$token}' target='_blank'>http://www.jawwadfida.com/phpDemo/food/reset.php?email={$email}&token={$token}</a>
        </p>";
        
        $mail->send();
        redirect("forgot.php?success=forgot_sent");
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
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
                    <h3 style="text-align:center" class="mb-4 billing-heading">Recover Account</h3>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" class="form-control" name="email" placeholder="Enter your email">
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="form-group">
                            <button type="submit" name="forgot_submit" class="btn btn-primary btn-lg">Password Recovery</button>
                        </div>
                    </div>

                    <input type="hidden" class="hide" name="token" id="token" value="">

                </form>

            </div>

        </div>
    </div>
</section>





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