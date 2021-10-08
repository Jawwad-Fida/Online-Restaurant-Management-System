<!-- Header -->
<?php include "includes/header.php"; ?>

<?php
if (isset($_GET['cancel'])) {
    $booking_id = $_GET['cancel'];
    $status = "cancel";
    $stmt = prepare_query("UPDATE reservation SET status=? WHERE booking_id=?");
    $stmt->bindParam(1, $status, PDO::PARAM_STR);
    $stmt->bindParam(2, $booking_id, PDO::PARAM_STR);
    $stmt->execute();
    unset($stmt);
    redirect("reservation_pending.php");
}
?>


<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/navigation.php"; ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <div class="col-lg-12">

                <h1 style="text-align:center" class="page-header">
                    Pending Reservations
                </h1>

                <div class="col-md-12">

                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Booking Id</th>
                                <th>Customer Name</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Mobile number</th>
                                <th>Reservation number</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            //get customer id if available
                            if (isset($_SESSION['customer_id'])) {
                                $cus_id = $_SESSION['customer_id'];
                            }
                            $role = $_SESSION['user_role'];

                            if ($role == 'admin') {
                                $status = 'pending';
                                $result = query("SELECT * FROM reservation WHERE status='{$status}' ORDER BY booking_id DESC");
                                $stmt = $result;

                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $booking_id = $row['booking_id'];
                                    $cus_name = $row['cust_name'];
                                    $reservation_date =  $row['reservation_date'];
                                    $reservation_time =  $row['reservation_time'];
                                    $mobile_number =  $row['mobile_number'];
                                    $identify_num = $row['identify_num'];

                                    //close php tag so that we can include some html inside the php while loop
                            ?>
                                    <tr>
                                        <td><?php echo $booking_id; ?></td>
                                        <td><?php echo $cus_name; ?></td>
                                        <td><?php echo $reservation_date; ?></td>
                                        <td><?php echo $reservation_time; ?></td>
                                        <td><?php echo $mobile_number; ?></td>
                                        <td><?php echo $identify_num; ?></td>
                                        <td>
                                            <a class="btn btn-success" href="reservation_pending.php?success=<?php echo $booking_id; ?>">Confirm</a>
                                            <a class="btn btn-danger" onClick="javascript: return confirm('Do want to cancel this order?');" href="reservation_pending.php?cancel=<?php echo $booking_id; ?>">Cancel</a>
                                        </td>
                                    </tr>

                                <?php
                                }
                                if (isset($_GET['success'])) {
                                    //There is another form in the file below - for updating reservations
                                    include "update_reservations.php";
                                }
                            } elseif ($role == 'customer') {
                                $status = 'pending';
                                $result = query("SELECT * FROM reservation WHERE status='{$status}' AND cust_id={$cus_id} ORDER BY booking_id DESC");
                                $stmt = $result;

                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $booking_id = $row['booking_id'];
                                    $cus_name = $row['cust_name'];
                                    $reservation_date =  $row['reservation_date'];
                                    $reservation_time =  $row['reservation_time'];
                                    $mobile_number =  $row['mobile_number'];
                                    $identify_num = $row['identify_num'];

                                ?>

                                    <tr>
                                        <td><?php echo $booking_id; ?></td>
                                        <td><?php echo $cus_name; ?></td>
                                        <td><?php echo $reservation_date; ?></td>
                                        <td><?php echo $reservation_time; ?></td>
                                        <td><?php echo $mobile_number; ?></td>
                                        <td><?php echo $identify_num; ?></td>
                                        <td>
                                            <a class="btn btn-danger" onClick="javascript: return confirm('Do want to cancel this order?');" href="reservation_pending.php?cancel=<?php echo $booking_id; ?>">Cancel</a>
                                        </td>
                                    </tr>

                            <?php }
                            } ?>

                        </tbody>


                    </table>
                    <!--End of Table-->
                </div>

            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Footer -->
<?php include "includes/footer.php"; ?>