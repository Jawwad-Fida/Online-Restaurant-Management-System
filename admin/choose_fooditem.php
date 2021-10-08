<?php include "includes/header.php"; ?>

<?php
//echo $_SESSION['user_id'] ."<br>";
//echo $_SESSION['user_role'] ."<br>";
//echo $_SESSION['customer_id']
//echo $_SESSION['driver_id']
?>

<div id="wrapper">

    <?php include "includes/navigation.php"; ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <h1 style="text-align:center">View FoodItems</h1>

            <h3>Select a category</h3>
            <br>

            <?php
            $stmt = query("SELECT cat_id FROM category WHERE cat_title='Drinks'");
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $drinks_id = $row['cat_id'];

            $stmt = query("SELECT cat_id FROM category WHERE cat_title='Starters'");
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $starter_id = $row['cat_id'];

            $stmt = query("SELECT cat_id FROM category WHERE cat_title='Dessert'");
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $dessert_id = $row['cat_id'];

            $stmt = query("SELECT cat_id FROM category WHERE cat_title='Main Dish'");
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $main_dish_id = $row['cat_id'];

            ?>

            <a class="btn btn-success btn-block" href="view_fooditem.php?display=<?php echo $drinks_id; ?>">Drinks</a><br><br>
            <a class="btn btn-success btn-block" href="view_fooditem.php?display=<?php echo $starter_id; ?>">Starters</a><br><br>
            <a class="btn btn-success btn-block" href="view_fooditem.php?display=<?php echo $dessert_id; ?>">Dessert</a><br><br>
            <a class="btn btn-success btn-block" href="view_fooditem.php?display=<?php echo $main_dish_id; ?>">Main</a><br><br>

        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<?php include "includes/footer.php"; ?>