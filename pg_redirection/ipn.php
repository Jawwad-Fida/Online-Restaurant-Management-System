<?php
//This page is to get notifications based on the satus of the customers payment - Instant Payment Notification (IPN)
session_start();

error_reporting(0);

require_once __DIR__ . "/../lib/SslCommerzNotification.php";
include __DIR__ . "/../payment_dbconn.php";
include __DIR__ . "/../OrderTransaction.php";

use SslCommerz\SslCommerzNotification;

if (empty($_POST['tran_id']) || empty($_POST['status'])) {
    echo "Invalid Information.";
    exit;
}

//Get these informations as post (Initial form data was submitted as post) (all other data have collected as post)
$tran_id = $_POST['tran_id'];
$status  = $_POST['status'];

$sslc  = new SslCommerzNotification();
$query = new OrderTransaction();

$sql    = $query->getRecordQuery($tran_id);
$result = $conn_integration->query($sql);
$row    = $result->fetch_array(MYSQLI_ASSOC);

if (empty($row)) {

    echo "Invalid Transaction ID.";
    exit;

}

//perform operations based on payment status - (switch-case)
switch ($status) {
    case 'VALID':

        if ($row['status'] == 'Pending') {

            $amount   = $_POST['amount'];
            $currency = $_POST['currency'];

            if (empty($_POST['amount']) || empty($_POST['currency'])) {

                echo "Invalid Information.";
                exit;

            }

            $validation = $sslc->orderValidate($tran_id, $amount, $currency, $_POST);

            if ($validation == true) {

                $query = new OrderTransaction();
                $sql   = $query->updateTransactionQuery($tran_id, 'Success');

                if ($conn_integration->query($sql) === true) {
                    echo "Payment Record Updated Successfully";
                } else {
                    echo "Error updating record: " . $conn_integration->error;
                }

            } else {

                $query = new OrderTransaction();
                $sql   = $query->updateTransactionQuery($tran_id, 'Failed');

                echo "Payment was not valid";

            }

            unset($_SESSION['payment_values']);

        } else if ($row['status'] == 'Success') {

            echo "This order is already Successful";

        }

        break;

    case 'FAILED':

        $query = new OrderTransaction();
        $sql   = $query->updateTransactionQuery($tran_id, 'Failed');

        echo "Payment was failed";

        break;

    case 'CANCELLED':

        $query = new OrderTransaction();
        $sql   = $query->updateTransactionQuery($tran_id, 'Cancelled');

        echo "Payment was Cancelled";

        break;

    default:

        echo "Invalid Information.";

        break;
}
