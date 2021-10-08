<!-- Header -->
<?php include "includes/header.php";  ?>

<?php

if (isset($_POST['food_submit'])) {

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

    //Check for errors
    if (empty($product_title) || empty($product_description) || empty($product_price) || empty($product_quantity) || empty($product_keywords) || empty($product_short_description)) {
        redirect("add_fooditem.php?error=emptyFields");
        exit();
    }

    //------------QUERY-------------

    //UPLOAD FILE
    $product_image_upload = upload_image_item($product_image, $product_image_temp, $fileError, $fileSize);

    $stmt = prepare_query("INSERT INTO food_items(quantity,category_id,food_name,food_image,food_price,description,short_description,keywords) VALUES(?,?,?,?,?,?,?,?)");
    $stmt->bindParam(1, $product_quantity, PDO::PARAM_STR);
    $stmt->bindParam(2, $product_category, PDO::PARAM_INT);
    $stmt->bindParam(3, $product_title, PDO::PARAM_STR);
    $stmt->bindParam(4, $product_image_upload, PDO::PARAM_STR);
    $stmt->bindParam(5, $product_price, PDO::PARAM_STR);
    $stmt->bindParam(6, $product_description, PDO::PARAM_STR);
    $stmt->bindParam(7, $product_short_description, PDO::PARAM_STR);
    $stmt->bindParam(8, $product_keywords, PDO::PARAM_STR);

    $stmt->execute();
    //$last_id = last_inserted_id();
    unset($stmt);

    redirect("add_fooditem.php?success=product_add&cat_id={$product_category}");
}

?>


<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/navigation.php";  ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <div class="col-md-12">

                <?php

                if (isset($_GET['success'])) {
                    if ($_GET['success'] == 'product_add') {
                        $the_cat_id = $_GET['cat_id'];
                        //echo $the_food_id;
                        echo "<p style='color:blue;font-size:25px;text-align:center'><a href='view_fooditem.php?display={$the_cat_id}'>Click here to view the Added Item</a></p>";

                    }
                }
                ?>

                <div class="row">
                    <h1 class="page-header" style="text-align:center">
                        Add Food Item
                    </h1>
                </div>

                <form action="" method="post" enctype="multipart/form-data">

                    <div class="col-md-8">

                        <div class="form-group">
                            <label for="product-title">Food name </label>
                            <input type="text" name="product_title" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="product-title">Food Description</label>
                            <textarea name="product_description" id="" cols="30" rows="10" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="product-title">Food Short Description</label>
                            <textarea name="product_short_description" id="" cols="30" rows="3" class="form-control"></textarea>
                        </div>

                        <div class="form-group row">
                            <div class="col-xs-3">
                                <label for="product-price">Food Price (BDT)</label>
                                <input type="number" name="product_price" class="form-control" size="60">
                            </div>
                        </div>

                    </div>

                    <!--Main Content-->

                    <!-- SIDEBAR-->

                    <aside id="admin_sidebar" class="col-md-4">

                        <!-- Product Categories-->

                        <div class="form-group">
                            <label for="category title">Category</label>
                            <select name="product_category" id="post_category" class="form-control">

                                <?php
                                $stmt = query("SELECT * FROM category");
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $cat_id = $row['cat_id'];
                                    $cat_title = $row['cat_title'];
                                    echo "<option value='{$cat_id}'>{$cat_title}</option>";
                                }
                                ?>

                            </select>
                        </div>

                        <!-- Product Quantity -->

                        <div class="form-group">
                            <label for="product-title">Quantity</label>
                            <input type="text" name="product_quantity" class="form-control">
                        </div>

                        <!-- Product Tags -->

                        <div class="form-group">
                            <label for="product-title">Item Keywords</label>
                            <input type="text" name="product_tags" class="form-control">
                        </div>

                        <!-- Product Image -->
                        <div class="form-group">
                            <label for="product-title">Image</label>
                            <input type="file" name="product_image">
                        </div>

                        <hr>

                        <!-- Submit button -->
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" name="food_submit" value="Add Food Item">
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