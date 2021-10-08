<!-- Header -->
<?php include "includes/header.php"; ?>

<?php
//delete user based on user id 
if (isset($_GET['delete'])) {
    $user_id = $_GET['delete'];
    $stmt = query("DELETE FROM users WHERE user_id={$user_id}");
    redirect("users_driver.php?success=user_delete");
}
?>

<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/navigation.php"; ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <div class="col-lg-12">

                <h1 style="text-align:center" class="page-header">
                    Delivery Man
                </h1>

                <div class="col-md-12">

                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Driver Id</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Mobile no.</th>
                                <th>Identication No.</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            //JOIN query
                            $result = query("SELECT d1.driver_id,d1.name,d1.mobile_number,u1.user_image,d1.identity_num,u1.user_id
                            FROM users u1
                            
                            JOIN delivery_man d1
                            ON d1.user_id = u1.user_id
                            GROUP BY d1.driver_id");
                            $stmt = $result;

                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $driver_id = $row['driver_id'];
                                $user_id = $row['user_id'];
                                $driver_name = $row['name'];
                                $mobile_number = $row['mobile_number'];
                                $identity_num = $row['identity_num'];
                                $user_image =  $row['user_image'];
                            
                                $image_directory = change_image_directory();
                                
                                //if image contains placeholder - i.e. no image
                                if ($user_image == 'http://placehold.it/400x400'){
                                    $user_image = "images/200x200.png";
                                }

                                //close php tag so that we can include some html inside the php while loop
                            ?>

                            <tr>
                                <td><?php echo $driver_id; ?></td>
                                <td><?php echo $driver_name; ?></td>
                                <td><img width="150" src="<?php echo $user_image; ?>">
                                </td>
                                <td><?php echo $mobile_number; ?></td>
                                <td><?php echo $identity_num; ?></td>
                                <td>
                                    <a class="btn btn-success" href="edit_driver.php?edit=<?php echo $user_id; ?>">Edit</a>
                                    <a class="btn btn-danger" href="users_driver.php?delete=<?php echo $user_id; ?>"><span class="glyphicon glyphicon-remove"></span></a>
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