<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>

<title>Success Page</title>
<h1 style='text-align: center'>SSLCOMMERZ Integration Success Page</h1>

<?php
error_reporting(0);
ini_set('display_errors', 0);

session_start();

require_once(__DIR__ . "/../lib/SslCommerzNotification.php");
include(__DIR__ . "/../payment_dbconn.php");
include(__DIR__ . "/../OrderTransaction.php");
include(__DIR__ . "/../vendor/autoload.php");

use SslCommerz\SslCommerzNotification;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

$STORE_NAME = getenv('Store_Name');

//Mailtrap Credentials
$SMTP_HOST = getenv('SMTP_HOST');
$SMTP_PORT = getenv('SMTP_PORT');
$SMTP_USER = getenv('SMTP_USER');
$SMTP_PASSWORD = getenv('SMTP_PASSWORD');
$SMTP_ENCRYPTION = PHPMailer::ENCRYPTION_STARTTLS;
$mail = new PHPMailer(true);

$sslc = new SslCommerzNotification();

//re-directed from checkout page
$tran_id = $_POST['tran_id'];
$amount =  $_POST['amount'];
$currency =  $_POST['currency'];

# SHIPMENT INFORMATION (Company Details) (fixed) [Adjust the details here again for the receipt]
$ship_name = $post_data['ship_name'] = "{$STORE_NAME}"; //store name
$ship_address = $post_data['ship_add1'] = "House:24, Road:11, Mohammadia Housing Society,Mohammadpur,Dhaka-1207";
$ship_phone = $post_data['ship_phone'] = "+880 1234 56789";

//$vat = $post_data['vat'];
//$discount_amount = $post_data['discount_amount'];
$vat = 100;
$discount_amount = 0;
$delivery_charge = 50;
$total_amount = $amount + $vat + $delivery_charge - $discount_amount;

$query = new OrderTransaction();
$sql = $query->getRecordQuery($tran_id); //get all records from orders table based on transaction id (unique for each customer)
$result = $conn_integration->query($sql);
$row = $result->fetch_array(MYSQLI_ASSOC); //fetch as associative array

//get some info from database table
$order_id = $row['order_id'];
$cus_id = $row['cus_id'];
$cus_name = $row['cus_name'];
$cus_email = $row['cus_email'];
$Receipt_number = $row['identify_num'];
$total_quantity = $row['total_quantity'];
$order_date = $row['order_date'];

$order_pin_code = $row['order_pin_code'];

if ($row['status'] == 'Pending') {

    //validate the payment - check whether the payment is success, fail, cancel

    $validation = $sslc->orderValidate($tran_id, $amount, $currency, $_POST);
    $tran_id = (string) $tran_id;

    //if the payment is valid (successfull), update the database
    if ($validation == TRUE) {
        $query = new OrderTransaction();
        $sql = $query->updateTransactionQuery($tran_id, 'Success'); //successfull payment

        if ($conn_integration->query($sql) === TRUE) {
            //echo "Payment Record Updated Successfully";
        } else {
            echo "Error updating record: " . $conn_integration->error;
        }

        echo "<h2 style='color: green; text-align: center;'>Congratulations! Your Transaction is Successful.</h2>";

?>
        <!-- After a successfull payment, display a receipt (receipt details can be changed based on us)-->

        <!-- Remember that we are re-directed from sslcommerznotification after payment validation, we can use the varibles
        in validate() function over there to display information here -->

        <table border="1" class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="2" style='text-align: center'>Sales Receipt of Payment</th>
                </tr>
            </thead>

            <tr>
                <td><span style="font-weight:bold">Receipt Number</span></td>
                <td><?php echo $Receipt_number; ?></td>
            </tr>
            <tr>
                <td><span style="font-weight:bold">Company Name</span></td>
                <td><?php echo $ship_name; ?></td>
            </tr>
            <tr>
                <td><span style="font-weight:bold">Company Address</span></td>
                <td><?php echo $ship_address; ?></td>
            </tr>
            <tr>
                <td>Company Contact Information</td>
                <td><?php echo $ship_phone; ?></td>
            </tr>
            <tr>
                <td><span style="font-weight:bold">Customer Name</span></td>
                <td><?php echo $cus_name; ?></td>
            </tr>
            <tr>
                <td><span style="font-weight:bold">Number of items bought</span></td>
                <td><?php echo $total_quantity; ?></td>
            </tr>
            <tr>
                <td><span style="font-weight:bold">Transaction ID</span></td>
                <td><?php echo $tran_id; ?></td>
            </tr>
            <tr>
                <td><span style="font-weight:bold">Transaction Date</span></td>
                <td><?php $trans_date = $_POST['tran_date'];
                    echo $trans_date; ?></td>
            </tr>
            <tr>
                <td>Card Type</td>
                <td><?php $card_type = $_POST['card_type'];
                    echo $card_type; ?></td>
            </tr>
            <tr>
                <td>Bank Transaction ID</td>
                <td><?php $bank_trans_id = $_POST['bank_tran_id'];
                    echo $bank_trans_id; ?></td>
            </tr>
            <tr>
                <td>Price of goods</td>
                <td><?php echo $amount; ?></td>
            </tr>
            <tr>
                <td><span style="font-weight:bold">Total Amount Paid (Including Vat + Delivery Charge)</span></td>
                <td><?php echo $total_amount; ?></td>
            </tr>
        </table>


<?php
        //Enter the receipt details into database receipt table 
        $sql = "INSERT INTO payment_details(order_id,cus_id,payment_type,receipt_number,receipt_date,transaction_id,transaction_date,bank_transaction_id,paid_amount) 
        VALUES ($order_id,$cus_id,'$card_type','$Receipt_number','$order_date','$tran_id','$trans_date','$bank_trans_id',$total_amount)";

        $result = $conn_integration->query($sql);

        try {
            //access class
            $email_to = "res_admin@gmail.com";

            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                   
            $mail->isSMTP();
            $mail->Host = $SMTP_HOST;
            $mail->Username = $SMTP_USER;
            $mail->Password = $SMTP_PASSWORD;
            $mail->Port = $SMTP_PORT;
            $mail->SMTPSecure = $SMTP_ENCRYPTION;
            $mail->SMTPAuth = true;

            //Recipients
            $mail->setFrom($cus_email, $cus_name);
            $mail->addAddress($email_to);

            // Content
            $mail->isHTML(true);
            $mail->Subject = "Order Confirmation Email for {$cus_name}";
            $mail->Body = "
            <table border='1' class='table table-bordered'>
            <thead>
                <tr>
                    <th colspan='2' style='text-align: center'>Sales Receipt of Payment</th>
                </tr>
            </thead>

            <tr>
                <td><span style='font-weight:bold'>Receipt Number</span></td>
                <td>{$Receipt_number}</td>
            </tr>
            <tr>
                <td><span style='font-weight:bold'>Company Name</span></td>
                <td>{$ship_name}</td>
            </tr>
            <tr>
                <td><span style='font-weight:bold'>Company Address</span></td>
                <td>{$ship_address}</td>
            </tr>
            <tr>
                <td>Company Contact Information</td>
                <td>{$ship_phone}</td>
            </tr>
            <tr>
                <td><span style='font-weight:bold'>Customer Name</span></td>
                <td>{$cus_name}</td>
            </tr>
            <tr>
                <td><span style='font-weight:bold'>Number of items bought</span></td>
                <td>{$total_quantity}</td>
            </tr>
            <tr>
                <td><span style='font-weight:bold'>Transaction ID</span></td>
                <td>{$tran_id}</td>
            </tr>
            <tr>
                <td><span style='font-weight:bold'>Transaction Date</span></td>
                <td>{$trans_date}</td>
            </tr>
            <tr>
                <td>Card Type</td>
                <td>{$card_type}</td>
            </tr>
            <tr>
                <td>Bank Transaction ID</td>
                <td>{$bank_trans_id}</td>
            </tr>
            <tr>
                <td>Price of goods</td>
                <td>{$amount}</td>
            </tr>
            <tr>
                <td><span style='font-weight:bold'>Total Amount Paid (Including Vat + Delivery Charge)</span></td>
                <td>{$total_amount}</td>
            </tr>
        </table>

        <br><br>

        <p>
        Receipt Number = '{$Receipt_number}'<br>
        <strong>Order Pin code</strong> = '{$order_pin_code}'<br>
        Date and Time of Order = '{$order_date}'<br><br>
        Share the pin code with the delivery person when your product is delivered.
        </p>
        ";

            $mail->send();

            //redirect("index.php?success=customer_reserve");
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        echo "<a href='../index.php' class='btn btn-success btn-lg btn-block'>Click here to return to Home Page</a>";

        //create a search based on customer's trans_id or receipt number is a seperate document


    } else {
        $query = new OrderTransaction();
        $sql = $query->updateTransactionQuery($tran_id, 'Failed');
        echo $sql;
        echo "<h2 style='color: #ff0000; text-align: center'>Payment was not valid. Please contact with the merchant.</h2>";
    }

    unset($_SESSION['payment_values']);
} else if ($row['status'] == 'Success') {
    echo "This order is already Successful";
    echo "<a href='../index.php' class='btn btn-success btn-lg btn-block'>Click here to return to Home Page</a>";
} else {
    echo "Invalid Information";
}

session_destroy();
?>