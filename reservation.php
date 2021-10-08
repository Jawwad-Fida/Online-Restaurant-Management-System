<?php

declare(strict_types=1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();
ob_start();
include "includes/connect.php";
include "includes/functions.php";

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
if (is_customer() == true){
    $cus_id = $_SESSION['customer_id'];
    $stmt = query("SELECT u1.name,c1.mobile_number,c1.email
    FROM users u1    
    JOIN customers c1
    ON c1.user_id = u1.user_id
    WHERE c1.customer_id = {$cus_id}");
    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $current_name = $row['name'];
    $current_mobile_number = $row['mobile_number'];
    $current_email = $row['email'];
}
?>

<?php 
if (isset($_POST["reserve_submit"])) {
    $message = validate($_POST['message']);
    $current_name = validate($_POST['name']); //users
    $current_mobile_number = validate($_POST['number']); //customer
    $date = $_POST['reserve_date'];
    $time = $_POST['reserve_time'];
    $persons_reserved  = validate($_POST['persons_reserved']);

    $email_to = "res_admin@gmail.com"; //our email address

    if (empty($persons_reserved)) {
        redirect("index.php?error=emptyFields");
        exit();
    }

    $reservation_pin_code = generatePinCode(); //unique identification string generated each time
    $identify_num = generateKey();
    $status = "pending";

    $stmt = prepare_query("INSERT INTO reservation(cust_id,cust_name,mobile_number,persons_reserved,reservation_date,reservation_time,message,reserve_pin_code,status,identify_num) 
    VALUES(?,?,?,?,?,?,?,?,?,?)");
    $stmt->bindParam(1, $cus_id, PDO::PARAM_STR); 
    $stmt->bindParam(2, $current_name, PDO::PARAM_STR);
    $stmt->bindParam(3, $current_mobile_number, PDO::PARAM_STR);
    $stmt->bindParam(4, $persons_reserved, PDO::PARAM_INT);
    $stmt->bindParam(5, $date, PDO::PARAM_STR);
    $stmt->bindParam(6, $time, PDO::PARAM_STR);
    $stmt->bindParam(7, $message, PDO::PARAM_STR);
    $stmt->bindParam(8, $reservation_pin_code, PDO::PARAM_STR);
    $stmt->bindParam(9, $status, PDO::PARAM_STR);
    $stmt->bindParam(10, $identify_num, PDO::PARAM_STR);
    $stmt->execute();
    unset($stmt); 

    //mail later - fisrt check if database insert is okay
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
        $mail->setFrom($current_email, $current_name);
        $mail->addAddress($email_to);

        // Content
        $mail->isHTML(true);
        $mail->Subject = "Reservation Confirmation Email for {$current_name}";
        $mail->Body = "<p>
        Reservation number = '{$identify_num}',<br>
        <strong>Reservation Pin code</strong> = '{$reservation_pin_code}',<br>
        Date = '{$date}', Time = '{$time}',<br><br>
        Share the pin code with the employee on the counter to confirm your reservation at your designated time.
        </p>";

        $mail->send();

        redirect("index.php?success=customer_reserve");
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

?>