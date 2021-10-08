<?php include "includes/header.php"; ?>


<div id="wrapper">

    <?php include "includes/navigation.php"; ?>

    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="col-md-12">

                <h1 style="text-align:center" class="page-header">Profile Page</h1>

                <?php
                //get data of customer from database and display them
                $user_id = $_SESSION['user_id'];
                $role = $_SESSION['user_role'];
                if ($role == 'customer') {
                    $result = query("SELECT u1.name,u1.username,u1.user_email,u1.user_image,u1.identity_num,c1.mobile_number,c1.address,c1.city,c1.zipcode
                    FROM users u1

                    JOIN customers c1
                    ON c1.user_id = u1.user_id
                    WHERE u1.user_id = {$user_id}");

                    $stmt = $result;
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    $name = $row['name'];
                    $username = $row['username'];
                    $user_email = $row['user_email'];
                    $user_image = $row['user_image'];
                    $identity_num = $row['identity_num'];
                    $mobile_number = $row['mobile_number'];
                    $address = $row['address'];
                    $city = $row['city'];
                    $zipcode = $row['zipcode'];
                ?>

                    <div class="form-group">
                        <img style='display:block;margin-left:auto;margin-right:auto' width="200" src="<?php echo $user_image; ?>">
                    </div>

                    <table class="table table-bordered table-hover table-striped">
                        <tbody>
                            <tr>
                                <td style='font-weight:bold'>Name:</td>
                                <td><?php echo $name; ?></td>
                            </tr>
                            <tr>
                                <td style='font-weight:bold'>Username:</td>
                                <td><?php echo $username; ?></td>
                            </tr>
                            <tr>
                                <td style='font-weight:bold'>Email:</td>
                                <td><?php echo $user_email; ?></td>
                            </tr>
                            <tr>
                                <td style='font-weight:bold'>Mobile No.</td>
                                <td><?php echo $mobile_number; ?></td>
                            </tr>
                            <tr>
                                <td style='font-weight:bold'>Address</td>
                                <td><?php echo $address; ?></td>
                            </tr>
                            <tr>
                                <td style='font-weight:bold'>City</td>
                                <td><?php echo $city; ?></td>
                            </tr>
                            <tr>
                                <td style='font-weight:bold'>Zip code</td>
                                <td><?php echo $zipcode; ?></td>
                            </tr>
                            <tr>
                                <td style='font-weight:bold'>Identification number</td>
                                <td><?php echo $identity_num; ?></td>
                            </tr>

                        </tbody>
                    </table>

                <?php
                //get data of driver from database and display them
                } elseif ($role == 'driver') {
                    $result = query("SELECT u1.name,u1.username,u1.user_email,u1.user_image,d1.mobile_number,d1.address,d1.city,d1.salary
                    FROM users u1
                    
                    JOIN delivery_man d1
                    ON d1.user_id = u1.user_id
                    WHERE u1.user_id = {$user_id}");

                    $stmt = $result;
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    $name = $row['name'];
                    $username = $row['username'];
                    $user_email = $row['user_email'];
                    $user_image = $row['user_image'];
                    $mobile_number = $row['mobile_number'];
                    $address = $row['address'];
                    $city = $row['city'];
                    $salary = $row['salary'];
                ?>

                    <div class="form-group">
                        <img style='display:block;margin-left:auto;margin-right:auto' width="200" src="<?php echo $user_image; ?>">
                    </div>

                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td></td>
                            </tr>
                            <tr>
                                <td style='font-weight:bold'>Name:</td>
                                <td><?php echo $name; ?></td>
                            </tr>
                            <tr>
                                <td style='font-weight:bold'>Username:</td>
                                <td><?php echo $username; ?></td>
                            </tr>
                            <tr>
                                <td style='font-weight:bold'>Email:</td>
                                <td><?php echo $user_email; ?></td>
                            </tr>
                            <tr>
                                <td style='font-weight:bold'>Mobile No.</td>
                                <td><?php echo $mobile_number; ?></td>
                            </tr>
                            <tr>
                                <td style='font-weight:bold'>Address</td>
                                <td><?php echo $address; ?></td>
                            </tr>
                            <tr>
                                <td style='font-weight:bold'>City</td>
                                <td><?php echo $city; ?></td>
                            </tr>
                            <tr>
                                <td style='font-weight:bold'>Salary</td>
                                <td><?php echo $salary; ?></td>
                            </tr>

                        </tbody>
                    </table>

                <?php } ?>

            </div>

            <?php if (is_customer() == true) : ?>
                <a class="btn btn-success" style="text-align:center" href="edit_customer.php?edit=<?php echo $user_id; ?>">Click here to edit profile</a>
            <?php endif; ?>

        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<?php include "includes/footer.php"; ?>