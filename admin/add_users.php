<?php include "includes/header.php"; ?>

<?php
if (isset($_POST["register_submit"])) {
    $customer_name = validate($_POST['name']);
    $customer_username = validate($_POST['username']);
    $customer_email = validate($_POST['email']);
    $customer_password = validate($_POST['password']);
    $password_repeat = validate($_POST['password_repeat']);
    $mobile_number = validate($_POST['number']);

    $role = $_POST['role'];
    $customer_gender = $_POST['gender'];
    $customer_dob = $_POST['birthday'];

    $customer_username_size = strlen($customer_username);
    $password_size = strlen($customer_password);

    //For Files, we need $_FILES['form_name']['property'] - FILES have 5 properties
    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];
    $fileError = $_FILES['image']['error'];
    $fileSize = $_FILES['image']['size'];
    //NOTE: - files when uploaded will be sent to a temporary location. We move it from the temporary location -> to the location we want.

    //Checking for errors
    if (empty($customer_username) || empty($customer_password) || empty($customer_email) || empty($password_repeat) || empty($customer_name) || empty($mobile_number)) {
        redirect("add_users.php?error=emptyFields");
        exit();
    } elseif (!filter_var($customer_email, FILTER_VALIDATE_EMAIL)) {
        //check if email is valid
        redirect("add_users.php?error=invalid_email");
        exit();
    } elseif (!preg_match("/^[a-zA-Z]*$/", $customer_username)) {
        //check if input characters are valid
        redirect("add_users.php?error=invalid_username");
        exit();
    } elseif ($customer_username_size <= 2) {
        //check if length of username is valid
        redirect("add_users.php?error=invalid_name_length");
        exit();
    } elseif ($password_size <= 4) {
        //check if length of password is valid
        redirect("add_users.php?error=invalid_pwd_length");
        exit();
    } elseif ($customer_password !== $password_repeat) {
        //check if password are same
        redirect("add_users.php?error=pwd_no_match");
        exit();
    }

    //CHECKING FOR DUPLICATE USERS AND EMAILS 

    if (username_exists($customer_username) == 'true') {
        redirect("add_users.php?error=user_exists");
        exit();
    }

    if (email_exists($customer_email) == 'true') {
        redirect("add_users.php?error=email_exists");
        exit();
    }

    //------------QUERY-------------

    //UPLOAD FILE(image)
    $post_image_upload = upload_image($post_image, $post_image_temp, $fileError, $fileSize, $customer_username);
    if ($post_image_upload == NULL) {
        // if no image has been uploaded, then place a placeholder
        $post_image_upload = "http://placehold.it/400x400";
    }

    //$role = 'customer';
    $passwordHash = password_hash($customer_password, PASSWORD_DEFAULT);
    $identity_num = generateKey(); //unique identification string generated each time the button is clicked
    //(see if same system can be used for OTP order and reservation - part 1)

    $stmt = prepare_query("INSERT INTO users(user_role,name,username,user_email,user_password,user_image,date_of_birth,identity_num) VALUES(?,?,?,?,?,?,?,?)");
    $stmt->bindParam(1, $role, PDO::PARAM_STR); //bind parameters to the placeholders(?)
    $stmt->bindParam(2, $customer_name, PDO::PARAM_STR);
    $stmt->bindParam(3, $customer_username, PDO::PARAM_STR);
    $stmt->bindParam(4, $customer_email, PDO::PARAM_STR);
    $stmt->bindParam(5, $passwordHash, PDO::PARAM_STR);
    $stmt->bindParam(6, $post_image_upload, PDO::PARAM_STR);
    $stmt->bindParam(7, $customer_dob, PDO::PARAM_STR);
    $stmt->bindParam(8, $identity_num, PDO::PARAM_STR);
    $stmt->execute();
    unset($stmt); //close off prepare statement

    if ($role == "admin") {
        $result = query("SELECT user_id FROM users WHERE identity_num = '{$identity_num}'");
        $stmt = $result;
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $user_id =  $row["user_id"];

        $stmt2 = prepare_query("INSERT INTO admins(username,user_id,identity_num) VALUES(?,?,?)");
        $stmt2->bindParam(1, $customer_username, PDO::PARAM_STR);
        $stmt2->bindParam(2, $user_id, PDO::PARAM_STR);
        $stmt2->bindParam(3, $identity_num, PDO::PARAM_STR);
        $stmt2->execute();
        unset($stmt2);
        redirect("users_admin.php?success=register");
    } elseif ($role == "customer") {
        $result = query("SELECT user_id FROM users WHERE identity_num = '{$identity_num}'");
        $stmt = $result;
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $user_id =  $row["user_id"];

        $stmt2 = prepare_query("INSERT INTO customers(username,user_id,mobile_number,email,identity_num) VALUES(?,?,?,?,?)");
        $stmt2->bindParam(1, $customer_username, PDO::PARAM_STR);
        $stmt2->bindParam(2, $user_id, PDO::PARAM_STR);
        $stmt2->bindParam(3, $mobile_number, PDO::PARAM_STR);
        $stmt2->bindParam(4, $customer_email, PDO::PARAM_STR);
        $stmt2->bindParam(5, $identity_num, PDO::PARAM_STR);
        $stmt2->execute();
        unset($stmt2);
        redirect("users_customer.php?success=register");
    } elseif ($role == "driver") {
        $result = query("SELECT user_id FROM users WHERE identity_num = '{$identity_num}'");
        $stmt = $result;
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $user_id =  $row["user_id"];
        $salary = 10000;

        $stmt2 = prepare_query("INSERT INTO delivery_man(user_id,name,mobile_number,identity_num,salary) VALUES(?,?,?,?,?)");
        $stmt2->bindParam(1, $user_id, PDO::PARAM_STR);
        $stmt2->bindParam(2, $customer_name, PDO::PARAM_STR);
        $stmt2->bindParam(3, $mobile_number, PDO::PARAM_STR);
        $stmt2->bindParam(4, $identity_num, PDO::PARAM_STR);
        $stmt2->bindParam(5, $salary, PDO::PARAM_INT);
        $stmt2->execute();
        unset($stmt2);
        redirect("users_driver.php?success=register");
    }

}

?>


<div id="wrapper">

    <?php include "includes/navigation.php"; ?>

    <div id="page-wrapper">

        <div class="container-fluid">
            <h1 style="text-align:center;font-weight:bold;color:brown">ADD USERS</h1>
            <form action="" method="post" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name">
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username">
                </div>

                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" class="form-control" name="email">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password">
                </div>

                <div class="form-group">
                    <label for="password repeat">Repeat Password</label>
                    <input type="password" class="form-control" name="password_repeat">
                </div>

                <div class="form-group">
                    <label for="mobile no.">Mobile Number</label>
                    <input type="text" class="form-control" name="number">
                </div>

                <div class="form-group">
                    <label for="gender">Gender: </label>
                    <label for="male">Male</label>
                    <input type="radio" class="form-control" name="gender" value="male">
                    <label for="female">Female</label>
                    <input type="radio" class="form-control" name="gender" value="female">
                </div>

                <div class="form-group">
                    <label for="image">Upload Image</label>
                    <input type="file" name="image">
                </div>

                <div class="form-group">
                    <label for="role">User Role: </label>
                    <select name="role">
                        <option value="driver" selected>Delivery Man</option>
                        <option value="admin">Admin</option>
                        <option value="customer">Customer</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="birthday">Date of Birth:</label>
                    <input type="date" id="birthday" name="birthday" min="1980-01-01" max="2021-12-31">
                </div>

                <div class="form-group">
                    <input class="btn btn-primary" type="submit" name="register_submit" value="Create User">
                </div>

            </form>

        </div>
        <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <?php include "includes/footer.php"; ?>