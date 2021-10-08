<!-- Header -->
<?php include "includes/header.php";  ?>


<?php
//delete user based on user id 
if (isset($_GET['accept'])) {
    $order_id = $_GET['accept'];
    $driver_id = $_SESSION['driver_id'];
    $delivery_status = "On The Way";
    $stmt = prepare_query("UPDATE orders SET delivery_status=?,driver_id=? WHERE order_id=?");

    $stmt->bindParam(1, $delivery_status, PDO::PARAM_STR);
    $stmt->bindParam(2, $driver_id, PDO::PARAM_INT);
    $stmt->bindParam(3, $order_id, PDO::PARAM_INT);
    $stmt->execute();
    unset($stmt);

    redirect("unassigned_orders.php?success=delivery_accept");
}
?>


<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/navigation.php";  ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <div class="col-md-12">

                <div class="row">
                    <h1 style='text-align:center' class="page-header">
                        Accept a Order to deliver
                    </h1>
                </div>

                <div class="row panel-body">
                    <table class="table table-bordered table-hover table-striped">
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
                            $stmt = query("SELECT * FROM orders WHERE delivery_status='Not Assigned'");
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
                                    <td><a onClick="javascript: return confirm('Do want to deliver this order?');" href="unassigned_orders.php?accept=<?php echo $order_id; ?>" class="btn btn-success">Accept</a> </td>
                                </tr>

                            <?php } ?>



                        </tbody>

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