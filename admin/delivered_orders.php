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
                        Completed Orders
                    </h1>
                </div>

                <div class="row panel-body">
                    <table class="table table-bordered table-hover table-striped">

                        <?php
                        $role = $_SESSION['user_role'];
                        if ($role == 'driver') {
                        ?>
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer Name</th>
                                    <th>Order Date</th>
                                    <th>Total Amount</th>
                                    <th>Quantity</th>
                                    <th>Mobile number</th>
                                    <th>Address</th>
                                    <th>City</th>
                                    <th>Delivery Status</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php
                                $driver_id = $_SESSION['driver_id'];
                                $stmt = query("SELECT * FROM orders WHERE delivery_status='Delivered' && driver_id={$driver_id}");
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $order_id = $row['order_id'];
                                    $cus_id = $row['cus_id'];
                                    $cus_name = $row['cus_name'];
                                    $order_date = $row['order_date'];
                                    $total_amount = $row['total_amount'];
                                    $total_quantity = $row['total_quantity'];
                                    $delivery_status = $row['delivery_status'];

                                    $stmt2 = query("SELECT * FROM customers WHERE customer_id={$cus_id}");
                                    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

                                    $mobile_number = $row2['mobile_number'];
                                    $email = $row2['email'];
                                    $address = $row2['address'];
                                    $city = $row2['city'];

                                ?>

                                    <tr>
                                        <td><?php echo $order_id; ?></td>
                                        <td><?php echo $cus_name; ?></td>
                                        <td><?php echo $order_date; ?></td>
                                        <td><?php echo $total_amount; ?></td>
                                        <td><?php echo $total_quantity; ?></td>
                                        <td><?php echo $mobile_number; ?></td>
                                        <td><?php echo $address; ?></td>
                                        <td><?php echo $city; ?></td>
                                        <td><?php echo $delivery_status; ?></td>
                                    </tr>

                                <?php
                                }
                                ?>

                            </tbody>

                        <?php } ?>


                        <?php
                        //$role = $_SESSION['user_role'];
                        if ($role == 'customer') {
                        ?>
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Order Date</th>
                                    <th>Receipt Number</th>
                                    <th>Status</th>
                                    <th>Total Amount</th>
                                    <th>Quantity</th>
                                    <th>Delivery Status</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php
                                $customer_id = $_SESSION['customer_id'];
                                $stmt = query("SELECT * FROM orders WHERE delivery_status='Delivered' && cus_id={$customer_id} && status='Success'");
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $order_id = $row['order_id'];
                                    $receipt_number = $row['identify_num'];
                                    $order_date = $row['order_date'];
                                    $order_status = $row['status'];
                                    $total_amount = $row['total_amount'];
                                    $total_quantity = $row['total_quantity'];
                                    $delivery_status = $row['delivery_status'];

                                ?>
                                    <tr>
                                        <td><?php echo $order_id; ?></td>
                                        <td><?php echo $order_date; ?></td>
                                        <td><?php echo $receipt_number; ?></td>
                                        <td><?php echo $order_status; ?></td>
                                        <td><?php echo $total_amount; ?></td>
                                        <td><?php echo $total_quantity; ?></td>
                                        <td><?php echo $delivery_status; ?></td>
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
                                    <th>Order Date</th>
                                    <th>Receipt Number</th>
                                    <th>Total Amount</th>
                                    <th>Quantity</th>
                                    <th>Delivery Status</th>
                                    <th>Driver ID</th>
                                    <th>Driver Name</th>
                                    <th>Driver Mobile Number</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php
                                $stmt = query("SELECT * FROM orders WHERE delivery_status='Delivered' && status='Success'");
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $order_id = $row['order_id'];
                                    $cus_id = $row['cus_id'];
                                    $order_date = $row['order_date'];
                                    $order_status = $row['status'];
                                    $receipt_number = $row['identify_num'];
                                    $total_amount = $row['total_amount'];
                                    $total_quantity = $row['total_quantity'];
                                    $delivery_status = $row['delivery_status'];

                                    $driver_id = $row['driver_id'];

                                    if ($driver_id == 0) {
                                        $driver_name = "No driver yet";
                                        $driver_mobile_number = "No driver yet";
                                    } else {
                                        $stmt2 = query("SELECT * FROM delivery_man WHERE driver_id={$driver_id}");
                                        $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

                                        $driver_name = $row2['name'];
                                        $driver_mobile_number = $row2['mobile_number'];
                                    }
                                ?>
                                    <tr>
                                        <td><?php echo $order_id; ?></td>
                                        <td><?php echo $cus_id; ?></td>
                                        <td><?php echo $order_date; ?></td>
                                        <td><?php echo $receipt_number; ?></td>
                                        <td><?php echo $total_amount; ?></td>
                                        <td><?php echo $total_quantity; ?></td>
                                        <td><?php echo $delivery_status; ?></td>
                                        <td><?php echo $driver_id; ?></td>
                                        <td><?php echo $driver_name; ?></td>
                                        <td><?php echo $driver_mobile_number; ?></td>
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