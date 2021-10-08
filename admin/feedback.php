<!-- Header -->
<?php include "includes/header.php"; ?>

<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/navigation.php"; ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <div class="col-lg-12">

                <h1 style="text-align:center" class="page-header">
                    Customer Feedback
                </h1>

                <div class="col-md-12">

                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Customer Id</th>
                                <th>Username</th>
                                <th>Food Quality</th>
                                <th>Service</th>
                                <th>Suggestion</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            //JOIN query
                            $result = query("SELECT c1.username,f1.cust_id,f1.food_quality,f1.suggestion,f1.service
                            FROM customers c1
                            
                            JOIN feedback f1
                            ON f1.cust_id = c1.customer_id");
                            $stmt = $result;

                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $cust_id = $row['cust_id'];
                                $username =  $row['username'];
                                $food_quality =  $row['food_quality'];
                                $service =  $row['service'];
                                $suggestion =  $row['suggestion'];
                        
                                //close php tag so that we can include some html inside the php while loop
                            ?>

                            <tr>
                                <td><?php echo $cust_id; ?></td>
                                <td><?php echo $username; ?></td>
                                <td><?php echo $food_quality; ?></td>
                                <td><?php echo $service; ?></td>
                                <td><?php echo $suggestion; ?></td>
                            </tr>

                            <?php } ?>

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