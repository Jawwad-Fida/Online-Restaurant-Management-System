<!-- Header -->
<?php include "includes/header.php"; ?>

<?php
//display items in category 
if (isset($_GET['display'])) {
    $cat_id = $_GET['display'];
    $stmt = query("SELECT cat_title FROM category WHERE cat_id=$cat_id");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $cat_title = $row['cat_title'];
}
?>


<?php
//delete user based on food id 
if (isset($_GET['delete'])) {
    $food_id = $_GET['delete'];
    $stmt = query("DELETE FROM food_items WHERE food_id={$food_id}");
    redirect("choose_fooditem.php?success=item_delete");
}
?>


<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/navigation.php"; ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <div class="col-lg-12">

                <h1 style="text-align:center" class="page-header">
                    <?php echo "Items in " . $cat_title . " category"; ?>
                </h1>

                <div class="col-md-12">

                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Item Price</th>
                                <th>Item Image</th>
                                <th>Item quantity</th>
                                <th>Short description</th>
                                <th>Keywords</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            //JOIN query
                            $result = query("SELECT * FROM food_items WHERE category_id={$cat_id}");
                            $stmt = $result;

                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $food_id = $row['food_id'];
                                $quantity = $row['quantity'];
                                $food_name = $row['food_name'];
                                $food_price =  $row['food_price'];
                                $food_image =  $row['food_image'];
                                $short_description =  $row['short_description'];
                                $keywords =  $row['keywords'];

                                //close php tag so that we can include some html inside the php while loop
                            ?>

                                <tr>
                                    <td><?php echo $food_name; ?></td>
                                    <td><?php echo $food_price; ?></td>
                                    <td><img width="150" src="<?php echo $food_image; ?>">
                                    </td>
                                    <td><?php echo $quantity; ?></td>
                                    <td><?php echo $short_description; ?></td>
                                    <td><?php echo $keywords; ?></td>

                                    <?php if (is_admin() == true) : ?>
                                        <td>
                                            <a class="btn btn-success" href="edit_fooditem.php?edit=<?php echo $food_id; ?>">Edit</a>
                                            <a class="btn btn-danger" onClick="javascript: return confirm('Do want to delete this item?');" href="view_fooditem.php?delete=<?php echo $food_id; ?>"><span class="glyphicon glyphicon-remove"></span></a>
                                        </td>
                                    <?php endif; ?>

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