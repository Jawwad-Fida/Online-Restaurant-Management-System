<!DOCTYPE html>
<html lang="en">

<script type="text/javascript" src="https://me.kis.v2.scr.kaspersky-labs.com/FD126C42-EBFA-4E12-B309-BB3FDD723AC1/main.js?attr=J5mlo2lQ72fUOtrpfa0A2q-Edi5ok_9RLJcRfVB4rBFNL7nmwGF-mlIKF2dhZmnMyXMBF3DCKLPU-7_QnfrvuTibH7l0cr74K3cLBdSXB7m7KAPByJHIy7yOF_X5d88ubjuqnmaVtBbDdBRPDOMclP7GiZzf-dFWNQlFVybFAPSrnTLTL60WmyKyh3yTBddf9BNSS1GEL1YbPga3JrmK841kjFHtNqeDOwV9QHFg69859hZ9nQ9tF72VRXebrV1VO5hZ_haWi9-ydo3wesG2dLzaNvMJDTzmVA-CUZYY1sYJ_MHjLAaPnXoDW_IExtKs_BWGNqCMoPmKcpRBDj2l8fsAYMTNQkhVXnzNh-KvS4rKwhtSZiUsEO_6rcOO8LkIcVu0eprWl_98Q99XQgQuVk5tQ4oxxbpHUYY8P91CTL4cjmZ0_tSd0MONd2ohigJZUQDGrDBIoAljP8xoYDK1Vg" charset="UTF-8"></script><link rel="stylesheet" crossorigin="anonymous" href="https://me.kis.v2.scr.kaspersky-labs.com/E3E8934C-235A-4B0E-825A-35A08381A191/abn/main.css?attr=aHR0cHM6Ly9kb2MtMDQtODAtZG9jcy5nb29nbGV1c2VyY29udGVudC5jb20vZG9jcy9zZWN1cmVzYy9sNms0N2lrY2N2ODZyOGhyMGxvNjcxbGUzcXA3aGY2MC8xOW0xc3RsaWI1bTdlaDBtMDljanJrcDFxNmdwdmhiMC8xNjIyODMxODUwMDAwLzA0ODA4MzA2OTE4OTM4MDcxMzU5LzA0ODA4MzA2OTE4OTM4MDcxMzU5LzE4NmRDdDJVRHNMeHEyR2xlSjlicU9NTTFCM3VWSHpjSz9lPWRvd25sb2FkJmF1dGh1c2VyPTEmbm9uY2U9Z3F1NGdybW1uZ3Q1NCZ1c2VyPTA0ODA4MzA2OTE4OTM4MDcxMzU5Jmhhc2g9NmEza3RxNXVhaTBvMWl2cm9wbWt0cGV1ZGNoYjA1amQ"/><?php
include('header.php');
?>

<?php
if (isset($_POST['login_submit'])) {
    $username = validate($_POST['username']);
    $user_password = validate($_POST['user_password']);

    //check for errors
    if (empty($username) || empty($user_password)) {
        redirect("login.php?error=emptyFields");
        exit();
    }

    //check if username exists in database
    $stmt = login_user_exists($username);

    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //user exists
        //dehash the password from database (returns true or false)
        $pwdCheck = password_verify($user_password, $row['user_password']);

        //if password doesn't match (false)
        if ($pwdCheck == false) {
            //don't log in user
            redirect("login.php?error=password");
            exit();
        } else {
            //password is correct (true) - log in user
            session_start();

            //store information from database into global session variable
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_role'] = $row['user_role'];
            $_SESSION['username'] = $row['username'];

            //we need a session containing customer id and delivery man id (no need admin)
            $role = $row['user_role'];
            $id = $row['user_id'];

            if ($role == "customer") {
                $result = query("SELECT customer_id FROM customers WHERE user_id = {$id}");
                $stmt = $result;
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $_SESSION['customer_id'] =  $row['customer_id'];
            } elseif ($role == "driver") {
                $result = query("SELECT driver_id FROM delivery_man WHERE user_id = {$id}");
                $stmt = $result;
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $_SESSION['driver_id'] =  $row['driver_id'];
            }

            redirect("admin/index.php?success=login");
        }
    }
}
?>

<?php
include('navigation.php');
?>

<section class="ftco-section">

    <div class="container">


        <div class="row">
            <div class="col-xl-12 ftco-animate">
            
                <!-- Display error messages -->
                <?php display_error_message(); ?>

                <!-- Display success messages -->
                <?php display_success_message(); ?>

                <form action="" method="post" class="p-3 billing-form ftco-bg-dark p-md-5">
                    <h3 style="text-align:center" class="mb-4 billing-heading">Login</h3>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" placeholder="Enter your username">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="user_password" placeholder="Enter your password">
                        </div>
                    </div>


                    <div class="row justify-content-center">
                        <div class="form-group">
                            <button type="submit" name="login_submit" class="btn btn-primary btn-lg">LOG IN</button>
                        </div>
                    </div>
                    <br>

                    <div class="row justify-content-center">
                        <div class="form-group">
                            <a class="btn btn-danger btn-lg" href="forgot.php?forgot=<?php echo uniqid(true); ?>">Forgot Password?</a>
                        </div>
                    </div>


                </form>

            </div>

        </div>
    </div>
</section>


<?php
include('footer.php');
?>



<div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
        <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
        <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00" />
    </svg></div>
<script src="js/jquery.min.js"></script>
<script src="js/jquery-migrate-3.0.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.easing.1.3.js"></script>
<script src="js/jquery.waypoints.min.js"></script>
<script src="js/jquery.stellar.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/aos.js"></script>
<script src="js/jquery.animateNumber.min.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/jquery.timepicker.min.js"></script>
<script src="js/scrollax.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&amp;sensor=false"></script>
<script src="js/google-map.js"></script>
<script src="js/main.js"></script>
<script>
    $(document).ready(function() {

        var quantitiy = 0;
        $('.quantity-right-plus').click(function(e) {

            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            var quantity = parseInt($('#quantity').val());

            // If is not undefined

            $('#quantity').val(quantity + 1);


            // Increment

        });

        $('.quantity-left-minus').click(function(e) {
            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            var quantity = parseInt($('#quantity').val());

            // If is not undefined

            // Increment
            if (quantity > 0) {
                $('#quantity').val(quantity - 1);
            }
        });

    });
</script>

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-23581568-13');
</script>
</body>

<!-- Mirrored from preview.colorlib.com/theme/coffeeblend/checkout.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 18 Apr 2021 16:32:50 GMT -->

</html>