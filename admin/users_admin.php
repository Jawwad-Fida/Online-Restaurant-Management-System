<!-- Header -->
<?php include "includes/header.php"; ?>

<?php
//delete user based on user id 
if (isset($_GET['delete'])) {
    $user_id = $_GET['delete'];
    $stmt = query("DELETE FROM users WHERE user_id={$user_id}");
    redirect("users_admin.php?success=user_delete");
}
?>


<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/navigation.php"; ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <div class="col-lg-12">

                <h1 style="text-align:center" class="page-header">
                    Admin
                </h1>

                <div class="col-md-12">

                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Admin Id</th>
                                <th>User Id</th>
                                <th>Image</th>
                                <th>Username</th>
                                <th>Role</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            //JOIN query
                            $result = query("SELECT a1.admin_id,u1.user_id,a1.username,u1.user_image,u1.user_role
                            FROM users u1
                            
                            JOIN admins a1
                            ON a1.user_id = u1.user_id
                            GROUP BY a1.admin_id");
                            $stmt = $result;

                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $admin_id = $row['admin_id'];
                                $user_id = $row['user_id'];
                                $username =  $row['username'];
                                $user_image =  $row['user_image'];
                                $user_role =  $row['user_role'];
                                $image_directory = change_image_directory();
                                
                                //if image contains placeholder - i.e. no image
                                if ($user_image == 'http://placehold.it/400x400'){
                                    $user_image = "images/200x200.png";
                                }

                                //close php tag so that we can include some html inside the php while loop
                            ?>

                            <tr>
                                <td><?php echo $admin_id; ?></td>
                                <td><?php echo $user_id; ?></td>
                                <td><img width="150" src="<?php echo $user_image; ?>">
                                </td>
                                <td><?php echo $username; ?></td>
                                <td><?php echo $user_role; ?></td>
                                <td>
                                    <a class="btn btn-danger" href="users_admin.php?delete=<?php echo $user_id; ?>"><span class="glyphicon glyphicon-remove"></span></a>
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