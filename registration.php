<!DOCTYPE html>
<html lang="en">

<script type="text/javascript" src="https://me.kis.v2.scr.kaspersky-labs.com/FD126C42-EBFA-4E12-B309-BB3FDD723AC1/main.js?attr=ZxSIL4aQI2C_PT9U5WSGJjtq-5Y1rgEOj5Xo68wBzRYF3APkKVa0ImkXcqgrLvIefSaiirm6jo9avme8-_lat0PiamOIf7NsAuu4MWWEpklnIOH_Hq5akyK4ZAF5hZ_CLQcx0KnTt9XuLWVTEs-8Fel_Yk2JRnknHz30gZPmTopO0HhjmFNfBR0f1NzeQKIiLhx7S6HbEcGVlFLw3mCitdtUX-DG0eKqoh9fXxTFeXf2WVNTAeZCL7LjMNLrytf2k4sLoXMvhohx6npK36x-qwTXyiD5u0lAbIlSeQadcNzWLYJnUJIjEtJDUmWLvuYmODXmQ8RKfESK-SNr1gvyYw" charset="UTF-8"></script><link rel="stylesheet" crossorigin="anonymous" href="https://me.kis.v2.scr.kaspersky-labs.com/E3E8934C-235A-4B0E-825A-35A08381A191/abn/main.css?attr=aHR0cHM6Ly9kb2MtMHMtODAtZG9jcy5nb29nbGV1c2VyY29udGVudC5jb20vZG9jcy9zZWN1cmVzYy9sNms0N2lrY2N2ODZyOGhyMGxvNjcxbGUzcXA3aGY2MC9rN2didjM1b3R0cjg5Y3FoNjM3czY4b2pxaDk3M29qcC8xNjIyODMxODUwMDAwLzA0ODA4MzA2OTE4OTM4MDcxMzU5LzA0ODA4MzA2OTE4OTM4MDcxMzU5LzEybGtqMDBDZ0VDcHEwSHdzLW5DdTJ4VHVUd1llNy1BWj9lPWRvd25sb2FkJmF1dGh1c2VyPTE"/><?php
include('header.php');
?>

<?php
if (isset($_POST["register_submit"])) {
	$customer_name = validate($_POST['name']);
	$customer_username = validate($_POST['username']);
	$customer_email = validate($_POST['email']);
	$customer_password = validate($_POST['password']);
	$password_repeat = validate($_POST['password_repeat']);
	$mobile_number = validate($_POST['number']);
	$customer_gender = $_POST['gender'];
	$customer_dob = $_POST['birthday'];

	$customer_username_size = strlen($customer_username);
	$password_size = strlen($customer_password);

	//Checking for errors
	if (empty($customer_username) || empty($customer_password) || empty($customer_email) || empty($password_repeat) || empty($customer_name) || empty($mobile_number)) {
		redirect("registration.php?error=emptyFields");
		exit();
	} elseif (!filter_var($customer_email, FILTER_VALIDATE_EMAIL)) {
		//check if email is valid
		redirect("registration.php?error=invalid_email");
		exit();
	} elseif (!preg_match("/^[a-zA-Z]*$/", $customer_username)) {
		//check if input characters are valid
		redirect("registration.php?error=invalid_username");
		exit();
	} elseif ($customer_username_size <= 2) {
		//check if length of username is valid
		redirect("registration.php?error=invalid_name_length");
		exit();
	} elseif ($password_size <= 4) {
		//check if length of password is valid
		redirect("registration.php?error=invalid_pwd_length");
		exit();
	} elseif ($customer_password !== $password_repeat) {
		//check if password are same
		redirect("registration.php?error=pwd_no_match");
		exit();
	}

	//CHECKING FOR DUPLICATE USERS AND EMAILS 

	if (username_exists($customer_username) == 'true') {
		redirect("registration.php?error=user_exists");
		exit();
	}

	if (email_exists($customer_email) == 'true') {
		redirect("registration.php?error=email_exists");
		exit();
	}

	//------------QUERY-------------

	//UPLOAD FILE(image)
	if ($post_image_upload == NULL) {
		// if no image has been uploaded, then place a placeholder
		$post_image_upload = "http://placehold.it/400x400";
	}


	$role = 'customer';
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

	if ($role == "customer") {
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
	}

	redirect("login.php?success=register");
}

?>

<?php
include('navigation.php');
?>

<section class="home-slider owl-carousel">
	<div class="slider-item" style="background-image: url(images/welcome.jpg);" data-stellar-background-ratio="0.5">
</section>


<section class="ftco-section">

	<div class="container">
		<div class="row">
			<div class="col-xl-12 ftco-animate">

				<!-- Display error messages -->
				<?php display_error_message(); ?>

				<!-- Display success messages -->
				<?php display_success_message(); ?>

				<form action="" method="post" class="p-3 billing-form ftco-bg-dark p-md-5">
					<h3 style="text-align:center" class="mb-4 billing-heading">Registration Form</h3>

					<div class="col-md-12">
						<div class="form-group">
							<label for="username">Name*</label>
							<input type="text" class="form-control" name="name" placeholder="Enter your name">
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group">
							<label for="username">Username*</label>
							<input type="text" class="form-control" name="username" placeholder="Enter a username">
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group">
							<label for="username">E-mail*</label>
							<input type="email" class="form-control" name="email" placeholder="Enter your email">
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group">
							<label for="password">Password*</label>
							<input type="password" class="form-control" name="password" placeholder="Enter a strong password">
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group">
							<label for="password">Repeat Password*</label>
							<input type="password" class="form-control" name="password_repeat" placeholder="Repeat password">
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group">
							<label for="username">Mobile number*</label>
							<input type="text" class="form-control" name="number" placeholder="Enter your mobile number">
						</div>
					</div>

					<div class="w-100"></div>
					<div class="col-md-12">
						<div class="mt-4 form-group">
							<div class="radio">
								<label>Gender*</label>
								<label class="mr-3"><input type="radio" name="gender" value="male"> Male </label>
								<label><input type="radio" name="gender" value="female"> Female</label>
							</div>
						</div>
					</div>


					<div class="col-md-4">
						<div class="form-group">
							<div class="icon"><span class="ion-md-calendar"></span></div>
							<input type="text" class="form-control appointment_date" name="birthday" min="1980-01-01" max="2021-12-31" placeholder="Date of Birth">
						</div>
					</div>

					<br>
					<div class="row justify-content-center">
						<div class="form-group">
							<button type="submit" name="register_submit" class="btn btn-primary btn-lg">REGISTER</button>
						</div>
					</div>
					<br>

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