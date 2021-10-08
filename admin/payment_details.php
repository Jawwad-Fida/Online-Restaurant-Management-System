<!-- Header -->
<?php include "includes/header.php";  ?>

<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/navigation.php";  ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <div class="col-md-12">

                <div class="row">
                    <h1 style='text-align:center' class="page-header">
                        Payment Details
                    </h1>
                </div>

                <div class="row panel-body">
                    <table class="table table-bordered table-hover table-striped">

                        <?php
                        $role = $_SESSION['user_role'];
                        if ($role == 'customer') {
                        ?>
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Receipt Number</th>
                                    <th>Receipt Date</th>
                                    <th>Transaction ID</th>
                                    <th>Transaction Date</th>
                                    <th>Payment Type</th>
                                    <th>Bank Transaction ID</th>
                                    <th>Total Amount</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php
                                $customer_id = $_SESSION['customer_id'];
                                $stmt = query("SELECT * FROM orders WHERE delivery_status='Delivered' && cus_id={$customer_id} && status='Success'");
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $order_id = $row['order_id'];

                                    $stmt2 = query("SELECT * FROM payment_details WHERE order_id={$order_id}");
                                    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

                                    $receipt_number = $row2['receipt_number'];
                                    $receipt_date = $row2['receipt_date'];
                                    $transaction_id = $row2['transaction_id'];
                                    $transaction_date = $row2['transaction_date'];
                                    $payment_type = $row2['payment_type'];
                                    $bank_transaction_id = $row2['bank_transaction_id'];
                                    $paid_amount = $row2['paid_amount'];
                                ?>
                                    <tr>
                                        <td><?php echo $order_id; ?></td>
                                        <td><?php echo $receipt_number; ?></td>
                                        <td><?php echo $receipt_date; ?></td>
                                        <td><?php echo $transaction_id; ?></td>
                                        <td><?php echo $transaction_date; ?></td>
                                        <td><?php echo $payment_type; ?></td>
                                        <td><?php echo $bank_transaction_id; ?></td>
                                        <td><?php echo $paid_amount; ?></td>
                                    </tr>

                                <?php
                                }
                                ?>

                            </tbody>

                        <?php } ?>

                        <?php
                        $role = $_SESSION['user_role'];
                        if ($role == 'admin') {
                        ?>
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer ID</th>
                                    <th>Customer Email</th>
                                    <th>Receipt Number</th>
                                    <th>Receipt Date</th>
                                    <th>Transaction ID</th>
                                    <th>Transaction Date</th>
                                    <th>Payment Type</th>
                                    <th>Bank Transaction ID</th>
                                    <th>Total Amount</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php
                                $stmt = query("SELECT * FROM orders WHERE delivery_status='Delivered' && status='Success'");
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $order_id = $row['order_id'];
                                    $cus_id = $row['cus_id'];
                                    $cus_email = $row['cus_email'];

                                    $stmt2 = query("SELECT * FROM payment_details WHERE order_id={$order_id}");
                                    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

                                    $receipt_number = $row2['receipt_number'];
                                    $receipt_date = $row2['receipt_date'];
                                    $transaction_id = $row2['transaction_id'];
                                    $transaction_date = $row2['transaction_date'];
                                    $payment_type = $row2['payment_type'];
                                    $bank_transaction_id = $row2['bank_transaction_id'];
                                    $paid_amount = $row2['paid_amount'];

                                ?>
                                    <tr>
                                        <td><?php echo $order_id; ?></td>
                                        <td><?php echo $cus_id; ?></td>
                                        <td><?php echo $cus_email; ?></td>
                                        <td><?php echo $receipt_number; ?></td>
                                        <td><?php echo $receipt_date; ?></td>
                                        <td><?php echo $transaction_id; ?></td>
                                        <td><?php echo $transaction_date; ?></td>
                                        <td><?php echo $payment_type; ?></td>
                                        <td><?php echo $bank_transaction_id; ?></td>
                                        <td><?php echo $paid_amount; ?></td>
                                    </tr>

                                <?php
                                }
                                ?>

                            </tbody>

                        <?php } ?>

                    </table>
                </div>

            </div>
            <!-- /.container-fluid -->


        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
</div>

<!-- Footer -->
<?php include "includes/footer.php";  ?>