<!-- Header -->
<?php include "includes/header.php"; ?>

<?php
//add category
if (isset($_POST['add_category'])) {
    $category_title = validate($_POST['category_title']);

    //Check for errors
    if (empty($category_title)) {
        redirect("categories.php?error=emptyFields");
        exit();
    }

    $stmt = prepare_query("INSERT INTO category(cat_title) VALUES(?)");
    $stmt->bindParam(1, $category_title, PDO::PARAM_STR);
    $stmt->execute();
    unset($stmt);

    redirect("categories.php?success=category_add");
}
?>

<?php
//delete category based on id 
if (isset($_GET['delete'])) {
    $category_id = $_GET['delete'];
    $stmt = query("DELETE FROM category WHERE cat_id={$category_id}");
    redirect("categories.php?success=category_delete");
}
?>


<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/navigation.php"; ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <h1 style="text-align:center" class="page-header">
                Food Categories
            </h1>

            <div class="col-md-4">

                <form action="" method="post">

                    <div class="form-group">
                        <label for="category-title">Title</label>
                        <input type="text" name="category_title" class="form-control">
                    </div>

                    <div class="form-group">
                        <input type="submit" name="add_category" class="btn btn-primary" value="Add Category">
                    </div>
                </form>

                <?php
                if (isset($_GET['edit'])) {
                    //There is another form in the file below - for updating categories
                    include "update_categories.php";
                }
                ?>

            </div>

            <div class="col-md-8">
                <table class="table table-bordered table-hover table-striped">

                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Title</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $stmt = query("SELECT * FROM category");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $category_id = $row['cat_id'];
                            $category_title =  $row['cat_title'];
                        ?>

                            <tr>
                                <td><?php echo $category_id; ?></td>
                                <td><?php echo $category_title; ?></td>
                                <td>
                                    <a class="btn btn-success" href="categories.php?edit=<?php echo $category_id; ?>">Edit</a>
                                    <a class="btn btn-danger" onClick="javascript: return confirm('Do want to delete this category?');" href="categories.php?delete=<?php echo $category_id; ?>"><span class="glyphicon glyphicon-remove"></span></a>
                                </td>
                            </tr>

                        <?php } ?>

                    </tbody>

                </table>


            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Footer -->
<?php include "includes/footer.php"; ?>