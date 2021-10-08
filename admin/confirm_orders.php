<!-- Form to update data in database -->
<form action="" method="post">

    <div class="form-group">
        <label for="title">Confirm Order</label>

        <?php
        if (isset($_GET['success'])) {
            $order_id = $_GET['success']; //collect data from url

            $stmt = query("SELECT identify_num,order_pin_code,order_date FROM orders WHERE order_id={$order_id}");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $identify_num = $row['identify_num'];
                $order_pin_code =  $row['order_pin_code'];
                $order_date =  $row['order_date'];

                //close php tag so that we can include some HTML within the loop 
        ?>
                <!-- This Field will only appear when success option is clicked -->
                <p>Receipt Number = <?php echo $identify_num; ?></p>
                <input type="text" class="form-control" name="pin_code" placeholder="Enter pin code for confirmation">
        <?php
            }
        }
        ?>

        <?php
        //update category 
        if (isset($_POST['update_status'])) {
            $pin_code = validate($_POST['pin_code']);
            $status = "Delivered";

            //Check for errors
            if (empty($pin_code)) {
                redirect("assigned_orders.php?error=emptyFields");
                exit();
            }

            //match pin code from database and pin code entered
            if($pin_code != $order_pin_code){
                redirect("assigned_orders.php?error=pin_no_match");
                exit();
            }

            $stmt = prepare_query("UPDATE orders SET delivery_status=? WHERE order_id=?");
            $stmt->bindParam(1, $status, PDO::PARAM_STR);
            $stmt->bindParam(2, $order_id, PDO::PARAM_STR);

            $stmt->execute();
            unset($stmt);

            redirect("assigned_orders.php");
        }
        ?>

    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_status" value="Confirm">
    </div>

</form>