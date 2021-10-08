<!-- Header -->
<?php include "includes/header.php";  ?>

<?php
//display food item
if (isset($_GET['edit'])) {
    $food_id = $_GET['edit'];
    $stmt = query("SELECT * FROM food_items WHERE food_id={$food_id}");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $old_food_id = $row['food_id'];
    $old_quantity = $row['quantity'];
    $old_food_name = $row['food_name'];
    $old_food_price =  $row['food_price'];
    $old_food_image =  $row['food_image'];
    $old_description =  $row['description'];
    $old_short_description =  $row['short_description'];
    $old_keywords =  $row['keywords'];
}

if (isset($_POST['food_update'])) {

    $product_title = validate($_POST['product_title']);
    $product_description = validate($_POST['product_description']);
    $product_price = validate($_POST['product_price']);
    $product_category = validate($_POST['product_category']);
    $product_quantity = validate($_POST['product_quantity']);
    $product_keywords = validate($_POST['product_tags']);
    $product_short_description = validate($_POST['product_short_description']);

    //For Files, we need $_FILES['form_name']['property'] - FILES have 5 properties
    $product_image = $_FILES['product_image']['name'];
    $product_image_temp = $_FILES['product_image']['tmp_name'];
    $fileError = $_FILES['product_image']['error'];
    $fileSize = $_FILES['product_image']['size'];
    //NOTE: - files when uploaded will be sent to a temporary location. We move it from the temporary location -> to the location we want.

    //------------QUERY-------------

    //UPLOAD FILE
    //return previous image file path from database and then delete it 
    $stmt3 = query("SELECT food_image FROM food_items WHERE food_id={$food_id}");
    $row = $stmt3->fetch(PDO::FETCH_ASSOC);
    $prev_image_path = $row['food_image'];
    if($prev_image_path != 'images/200x200.png'){
        unlink($prev_image_path);
    }
    unset($stmt3);

    $product_image_upload = upload_image_item($product_image, $product_image_temp, $fileError, $fileSize);

    //check if the image location is empty or not
    if (empty($product_image_upload)) {
        $product_image_upload = $old_food_image;
        //NOTE: - in this way, we can update product without the picture being lost
    }

    $stmt = prepare_query("UPDATE food_items 
    SET quantity=?,food_name=?,food_image=?,food_price=?,description=?,short_description=?,keywords=? 
    WHERE food_id=?");
    $stmt->bindParam(1, $product_quantity, PDO::PARAM_STR);
    $stmt->bindParam(2, $product_title, PDO::PARAM_STR);
    $stmt->bindParam(3, $product_image_upload, PDO::PARAM_STR);
    $stmt->bindParam(4, $product_price, PDO::PARAM_STR);
    $stmt->bindParam(5, $product_description, PDO::PARAM_STR);
    $stmt->bindParam(6, $product_short_description, PDO::PARAM_STR);
    $stmt->bindParam(7, $product_keywords, PDO::PARAM_STR);
    $stmt->bindParam(8, $food_id, PDO::PARAM_INT);

    $stmt->execute();
    unset($stmt);

    redirect("choose_fooditem.php?success=item_update");
}

?>

<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/navigation.php";  ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <div class="col-md-12">

                <div class="row">
                    <h1 class="page-header" style="text-align:center">
                        Update Food Item
                    </h1>
                </div>

                <form action="" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <!-- Upload Image  -->
                        <img style='display:block;margin-left:auto;margin-right:auto' width="150" src="<?php echo $old_food_image; ?>">
                        <label for="post_image">Food Image</label>
                        <input type="file" name="product_image">
                    </div>
                    <br>

                    <div class="col-md-8">

                        <div class="form-group">
                            <label for="product-title">Food name </label>
                            <input type="text" name="product_title" class="form-control" value="<?php echo $old_food_name; ?>">
                        </div>

                        <div class="form-group">
                            <label for="product-title">Food Description</label>
                            <textarea name="product_description" id="" cols="30" rows="10" class="form-control">
                            <?php echo $old_description; ?>
                            </textarea>
                        </div>

                        <div class="form-group">
                            <label for="product-title">Food Short Description</label>
                            <textarea name="product_short_description" id="" cols="30" rows="3" class="form-control">
                            <?php echo $old_short_description; ?>
                            </textarea>
                        </div>

                        <div class="form-group row">
                            <div class="col-xs-3">
                                <label for="product-price">Food Price (BDT)</label>
                                <input type="number" name="product_price" class="form-control" size="60" value="<?php echo $old_food_price; ?>">
                            </div>
                        </div>

                    </div>

                    <!--Main Content-->

                    <!-- SIDEBAR-->

                    <aside id="admin_sidebar" class="col-md-4">

                        <!-- Product Quantity -->

                        <div class="form-group">
                            <label for="product-title">Quantity</label>
                            <input type="text" name="product_quantity" class="form-control" value="<?php echo $old_quantity; ?>">
                        </div>

                        <!-- Product Tags -->

                        <div class="form-group">
                            <label for="product-title">Item Keywords</label>
                            <input type="text" name="product_tags" class="form-control" value="<?php echo $old_keywords; ?>">
                        </div>

                        <hr>

                        <!-- Submit button -->
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" name="food_update" value="Update Food Item">
                        </div>

                    </aside>
                    <!--SIDEBAR-->

                </form>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
</div>

<!-- Footer -->
<?php include "includes/footer.php"; ?>