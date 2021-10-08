<!-- Form to update data in database -->
<form action="" method="post">

    <div class="form-group">
        <label for="title">Update Reservation</label>

        <?php
        if (isset($_GET['success'])) {
            $booking_id = $_GET['success']; //collect data from url

            $stmt = query("SELECT reserve_pin_code,status,identify_num FROM reservation WHERE booking_id={$booking_id}");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $identify_num = $row['identify_num'];
                $reserve_pin_code =  $row['reserve_pin_code'];
                $status =  $row['status'];

                //close php tag so that we can include some HTML within the loop 
        ?>
                <!-- This Field will only appear when success option is clicked -->
                <p>Reservation number = <?php echo $identify_num; ?></p>
                <input type="text" class="form-control" name="pin_code" placeholder="Enter pin code for confirmation">
        <?php
            }
        }
        ?>

        <?php
        //update category 
        if (isset($_POST['update_status'])) {
            $pin_code = validate($_POST['pin_code']);
            $status = "success";

            //Check for errors
            if (empty($pin_code)) {
                redirect("reservation_pending.php?error=emptyFields");
                exit();
            }

            //match pin code from database and pin code entered
            if($pin_code != $reserve_pin_code){
                redirect("reservation_pending.php?error=pin_no_match");
                exit();
            }

            $stmt = prepare_query("UPDATE reservation SET status=? WHERE booking_id=?");
            $stmt->bindParam(1, $status, PDO::PARAM_STR);
            $stmt->bindParam(2, $booking_id, PDO::PARAM_STR);

            $stmt->execute();
            unset($stmt);

            redirect("reservation_pending.php");
        }
        ?>

    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_status" value="Confirm">
    </div>

</form>