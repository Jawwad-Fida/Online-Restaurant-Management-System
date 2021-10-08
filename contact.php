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
if (isset($_POST['contact_submit'])) {
    $cus_id = $_SESSION['customer_id']; //collect customer id from global sessions variable
    $result = query("SELECT username,email FROM customers WHERE customer_id = {$cus_id}");
    $stmt = $result;
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $cus_username = $row['username'];
    $cus_email = $row['email'];

    $email_to = "res_admin@gmail.com"; //our email address
    $quality = validate($_POST['quality']);
    $services = validate($_POST['services']);
    $suggestions = validate($_POST['suggestions']);

    //Error message
    if (empty($quality) || empty($services) || empty($suggestions)) {
        redirect("contact.php?error=emptyFields");
        exit();
    }

    $quality = wordwrap($quality, 200); // use wordwrap() if lines are longer than 200 characters
    $services = wordwrap($services, 200);
    $suggestions = wordwrap($suggestions, 200);

    //query
    $stmt = prepare_query("INSERT INTO feedback(cust_id,food_quality,suggestion,service) VALUES(?,?,?,?)");
    $stmt->bindParam(1, $cus_id, PDO::PARAM_INT);
    $stmt->bindParam(2, $quality, PDO::PARAM_STR);
    $stmt->bindParam(3, $suggestions, PDO::PARAM_STR);
    $stmt->bindParam(4, $services, PDO::PARAM_STR);
    $stmt->execute();
    unset($stmt);

    //Setting up PHPMAILER
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
        $mail->setFrom($cus_email, $cus_username);
        $mail->addAddress($email_to);

        // Content
        $mail->isHTML(true);
        $mail->Subject = "Customer Feedback from {$cus_username}";
        $mail->Body = "<p>
        Food quality = '{$quality}',<br>
        Services = '{$services}',<br>
        Suggestions = '{$suggestions}'
        </p>";

        $mail->send();

        redirect("contact.php?success=feedback_sent");
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

?>


<?php
include('navigation.php');
?>

<section class="home-slider owl-carousel">
  <div class="slider-item" style="background-image: url(images/bg_9.jpg);" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
      <div class="row slider-text justify-content-center align-items-center">
        <div class="text-center col-md-7 col-sm-12 ftco-animate">
          <h1 class="mt-5 mb-3 bread">Customer Feedback</h1>
        </div>
      </div>
    </div>
  </div>
</section>


<section class="ftco-section contact-section">
  <div class="container mt-5">
    <div class="row block-9">

      <div class="col-md-4 contact-info ftco-animate">
        <div class="row">
          <div class="mb-4 col-md-12">
            <h2 class="h4">Contact Information</h2>
          </div>
          <div class="mb-3 col-md-12">
            <p><span>Address:</span><a href="#"> House:3, Road:11, Mohammadia Housing Society, Mohammadpur, Dhaka-1207.</a></p>
          </div>
          <div class="mb-3 col-md-12">
            <p><span>Phone:</span><a href="#"> +880 1234 56789</a></p>
          </div>
          <div class="mb-3 col-md-12">
            <p><span>Email:</span><a href="#"> res_admin@gmail.com</a></p>
          </div>
        </div>
      </div>


      <div class="col-md-1"></div>
      <div class="col-md-6 ftco-animate">

        <!-- Display error messages -->
        <?php display_error_message(); ?>

        <!-- Display success messages -->
        <?php display_success_message(); ?>

        <form action="" method="post" class="contact-form">

          <div class="form-group">
            <textarea cols="30" rows="5" class="form-control" name="quality" placeholder="Are you satisfied with the quality of food?"></textarea>
          </div>

          <div class="form-group">
            <textarea cols="30" rows="5" class="form-control" name="services" placeholder="Are you happy with our services?"></textarea>
          </div>

          <div class="form-group">
            <textarea cols="30" rows="5" class="form-control" name="suggestions" placeholder="Any Suggestions or Complaints?"></textarea>
          </div>

          <div class="form-group">
            <input type="submit" name="contact_submit" value="Send Message" class="px-5 py-3 btn btn-primary">
          </div>

        </form>
      </div>

    </div>
  </div>
</section>


<div id="map">
  <p><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3651.5417617601875!2d90.35316176445613!3d23.76371494418561!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c09ffaffd459%3A0x8268e2507d87e477!2sMohammadia%20Housing%20Society%2C%20Dhaka!5e0!3m2!1sen!2sbd!4v1621576102615!5m2!1sen!2sbd" width="1500" height="500" style="border:0;" allowfullscreen="" loading="lazy"></iframe></p>
</div>

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
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&amp;sensor=false"></script> -->
<script src="js/google-map.js"></script>
<script src="js/main.js"></script>

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


</html>