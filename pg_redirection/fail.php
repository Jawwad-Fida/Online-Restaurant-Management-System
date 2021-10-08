<?php
//if payment fails, we are re-directed here
if ($_POST['tran_id']) {

    include(__DIR__ ."/../payment_dbconn.php");
    include(__DIR__ . "/../OrderTransaction.php");

    $tran_id = trim($_POST['tran_id']);
    $query = new OrderTransaction();
    $sql = $query->getRecordQuery($tran_id);
    $result = $conn_integration->query($sql);
    $row = $result->fetch_array(MYSQLI_ASSOC);

    //check if the payment has failed
    if ($row['status'] == 'Pending') { 
        $query = new OrderTransaction();
        $sql = $query->updateTransactionQuery($tran_id, 'Failed'); //if failed, store Failed in status column of database

        if ($conn_integration->query($sql) === TRUE) {
            echo "<h1 style='color:red;font-size:30px;text-align:center'>Your Order has Failed</h1>";
        } else {
            echo "Error updating record: " . $conn_integration->error;
        }

        //otherwise, payment has already succedded. But due to huge traffic on the website, it may be slow
    } else if ($row['status'] == 'Success') {
        echo "This order is already successfull";
    } else {
        echo "Invalid Information";
    }

} else {

    echo "Invalid Information";
}

?>