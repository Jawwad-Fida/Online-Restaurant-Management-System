<!-- Form to update data in database -->
<form action="" method="post">

    <div class="form-group">
        <label for="cat-title">Edit Category</label>

        <?php
        //select which categories to update by clicking on link
        if (isset($_GET['edit'])) {
            $cat_id = $_GET['edit']; //collect data from url

            $stmt = query("SELECT cat_title FROM category WHERE cat_id={$cat_id}");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $category_title =  $row['cat_title'];

                //close php tag so that we can include some HTML within the loop 
        ?>
                <!-- This Field will only appear when edit option is clicked -->
                <input value="<?php echo $category_title; ?>" type="text" class="form-control" name="category_title">
        <?php
            }
        }
        ?>

        <?php
        //update category 
        if (isset($_POST['update_category'])) {
            $category_title = validate($_POST['category_title']);

            //Check for errors
            if (empty($category_title)) {
                redirect("categories.php?error=emptyFields");
                exit();
            }

            $stmt = prepare_query("UPDATE category SET cat_title=? WHERE cat_id=?");
            $stmt->bindParam(1, $category_title, PDO::PARAM_STR);
            $stmt->bindParam(2, $cat_id, PDO::PARAM_INT);
            $stmt->execute();
            unset($stmt);

            redirect("categories.php?success=category_update");
        }
        ?>

    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_category" value="Update Category">
    </div>

</form>