<?php include "includes/header.php"; ?>


<?php
//get data of user id from database - Join query
if (isset($_GET['edit'])) {
    $user_id = $_GET['edit'];
    $result = query("SELECT c1.username,c1.mobile_number,c1.email,u1.name,u1.user_password,u1.user_image,c1.address,c1.city,c1.zipcode
    FROM users u1
    
    JOIN customers c1
    ON c1.user_id = u1.user_id
    WHERE u1.user_id = {$user_id}");

    $stmt = $result;
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $old_name = $row['name'];
    $username = $row['username'];
    $old_email = $row['email'];
    $old_mobile_number = $row['mobile_number'];
    $old_password = $row['user_password'];
    $old_user_image = $row['user_image'];
    $old_address = $row['address'];
    $city = $row['city'];
    $old_zipcode = $row['zipcode'];
}
?>

<?php
// update user information 
if (isset($_POST['update_submit'])) {
    $email = validate($_POST['email']);
    $number = validate($_POST['number']);
    $address = validate($_POST['address']);
    $zipcode = validate($_POST['zipcode']);
    $city = $_POST['city'];

    //For Files, we need $_FILES['form_name']['property'] - FILES have 5 properties
    $name = validate($_POST['name']);
    $user_image = $_FILES['image']['name'];
    $user_image_temp = $_FILES['image']['tmp_name'];
    $fileError = $_FILES['image']['error'];
    $fileSize = $_FILES['image']['size'];
    //NOTE: - files when uploaded will be sent to a temporary location. We move it from the temporary location -> to the location we want.

    //Checking for errors
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        //check if email is valid
        redirect("edit_customer.php?error=invalid_email");
        exit();
    }

    //UPLOAD FILE
    //return previous image file path from database and then delete it 
    $stmt3 = query("SELECT user_image FROM users WHERE username='{$username}'");
    $row = $stmt3->fetch(PDO::FETCH_ASSOC);
    $prev_image_path = $row['user_image'];
    if($prev_image_path != 'images/200x200.png'){
        unlink($prev_image_path);
    }
    unset($stmt3);
    
    $user_image_upload = upload_image($user_image, $user_image_temp, $fileError, $fileSize, $username);

    //check if the image location is empty or not
    if (empty($user_image_upload)) {
        $user_image_upload = $old_user_image;
        //NOTE: - in this way, we can update product without the picture being lost
    }

    if (empty($new_password)) {
        //keep the old password
        $passwordHash = $old_password;
    } else {
        $new_password = validate($_POST['new_password']);
        $new_password_repeat = validate($_POST['new_password_repeat']);
        $password_size = strlen($new_password);

        if ($password_size <= 4) {
            //check if length of password is valid
            redirect("edit_customer.php?error=invalid_pwd_length");
            exit();
        } elseif ($new_password !== $new_password_repeat) {
            //check if password are same
            redirect("edit_customer.php?error=pwd_no_match");
            exit();
        }
        $passwordHash = password_hash($new_password, PASSWORD_DEFAULT);
    }

    //query
    $stmt1 = prepare_query("UPDATE users SET name=?,user_email=?,user_password=?,user_image=? WHERE user_id=?");
    $stmt1->bindParam(1, $name, PDO::PARAM_STR);
    $stmt1->bindParam(2, $email, PDO::PARAM_STR);
    $stmt1->bindParam(3, $passwordHash, PDO::PARAM_STR);
    $stmt1->bindParam(4, $user_image_upload, PDO::PARAM_STR);
    $stmt1->bindParam(5, $user_id, PDO::PARAM_INT);
    $stmt1->execute();
    unset($stmt1);

    $stmt2 = prepare_query("UPDATE customers SET mobile_number=?,email=?,address=?,city=?,zipcode=? WHERE user_id=?");
    $stmt2->bindParam(1, $number, PDO::PARAM_STR);
    $stmt2->bindParam(2, $email, PDO::PARAM_STR);
    $stmt2->bindParam(3, $address, PDO::PARAM_STR);
    $stmt2->bindParam(4, $city, PDO::PARAM_STR);
    $stmt2->bindParam(5, $zipcode, PDO::PARAM_STR);
    $stmt2->bindParam(6, $user_id, PDO::PARAM_INT);
    $stmt2->execute();
    unset($stmt2);

    redirect("profile.php?success=user_update");
}
?>


<div id="wrapper">

    <?php include "includes/navigation.php"; ?>

    <div id="page-wrapper">

        <div class="container-fluid">
            <h1 style="text-align:center;font-weight:bold;color:brown">Edit Profile</h1>

            <form action="" method="post" enctype="multipart/form-data">

                <div class="form-group">
                    <!-- Upload Image  -->
                    <img style='display:block;margin-left:auto;margin-right:auto' width="150" src="<?php echo $old_user_image; ?>">
                    <label for="post_image">User Image</label>
                    <input type="file" name="image">
                </div>
                <br>

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" value="<?php echo $old_name; ?>">
                </div>

                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" class="form-control" name="email" value="<?php echo $old_email; ?>">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="new_password" placeholder="Leave blank if you don't want to change current password">
                </div>

                <div class="form-group">
                    <label for="password repeat">Repeat Password</label>
                    <input type="password" class="form-control" name="new_password_repeat" placeholder="Leave blank if you don't want to change current password">
                </div>

                <div class="form-group">
                    <label for="mobile no.">Mobile Number</label>
                    <input type="text" class="form-control" name="number" value="<?php echo $old_mobile_number; ?>">
                </div>

                <div class="form-group">
                    <label for="mobile no.">Address</label>
                    <input type="text" class="form-control" name="address" value="<?php echo $old_address; ?>">
                </div>

                <div class="form-group">
                    <label for="mobile no.">City/State</label>
                    <select name="city">
                        <option value="Dhaka" selected>Dhaka</option>
                        <option value="Rangpur">Rangpur</option>
                        <option value="Rajshahi">Rajshahi</option>
                        <option value="Mymensingh">Mymensingh</option>
                        <option value="Sylhet">Sylhet</option>
                        <option value="Khulna">Khulna</option>
                        <option value="Barisal">Barisal</option>
                        <option value="Chittagong">Chittagong</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="mobile no.">Zip Code</label>
                    <input type="text" class="form-control" name="zipcode" value="<?php echo $old_zipcode; ?>">
                </div>

                <div class="form-group">
                    <input class="btn btn-primary" type="submit" name="update_submit" value="Update User">
                </div>

            </form>

        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<?php include "includes/footer.php"; ?>