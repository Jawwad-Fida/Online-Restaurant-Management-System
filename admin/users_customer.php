<!-- Header -->
<?php include "includes/header.php"; ?>

<?php
//delete user based on user id 
if (isset($_GET['delete'])) {
    $user_id = $_GET['delete'];
    $stmt = query("DELETE FROM users WHERE user_id={$user_id}");
    redirect("users_customer.php?success=user_delete");
}
?>


<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/navigation.php"; ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <div class="col-lg-12">

                <h1 style="text-align:center" class="page-header">
                    Customers
                </h1>

                <div class="col-md-12">

                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Customer Id</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Image</th>
                                <th>Mobile no.</th>
                                <th>Address</th>
                                <th>Identification No.</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            //JOIN query
                            $result = query("SELECT c1.customer_id,u1.user_id,u1.username,u1.user_email,c1.mobile_number,c1.address,u1.identity_num,u1.user_image
                            FROM users u1

                            JOIN customers c1
                            ON c1.user_id = u1.user_id
                            GROUP BY c1.customer_id");
                            $stmt = $result;
                            
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $customer_id = $row['customer_id'];
                                $user_id = $row['user_id'];
                                $user_email = $row['user_email'];
                                $mobile_number = $row['mobile_number'];
                                $address = $row['address'];
                                $identity_num = $row['identity_num'];
                                $username =  $row['username'];
                                $user_image =  $row['user_image'];
                            
                                $image_directory = change_image_directory();
                                
                                //if image contains placeholder - i.e. no image
                                if ($user_image == 'http://placehold.it/400x400'){
                                    $user_image = "images/200x200.png";
                                }

                                //close php tag so that we can include some html inside the php while loop
                            ?>

                            <tr>
                                <td><?php echo $customer_id; ?></td>
                                <td><?php echo $username; ?></td>
                                <td><?php echo $user_email; ?></td>
                                <td><img width="150" src="<?php echo $user_image; ?>">
                                </td>
                                <td><?php echo $mobile_number; ?></td>
                                <td><?php echo $address; ?></td>
                                <td><?php echo $identity_num; ?></td>
                                <td>
                                    <a class="btn btn-success" href="edit_customer.php?edit=<?php echo $user_id; ?>">Edit</a>
                                    <a class="btn btn-danger" onClick="javascript: return confirm('Do want to delete this user?');" href="users_customer.php?delete=<?php echo $user_id; ?>"><span class="glyphicon glyphicon-remove"></span></a>
                                </td>
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