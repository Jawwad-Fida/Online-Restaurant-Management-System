<!DOCTYPE html>
<html lang="en">

<?php
include('header.php');
?>

<?php
include('navigation.php');
?>


<?php
//fixed variables
$Total_amount = 0;
$Discount = 0;
?>

<?php
if (isset($_SESSION['item_total'])) {
	$item_total = $_SESSION['item_total'];
}

if (isset($_SESSION['item_quantity'])) {
	$item_quantity = $_SESSION['item_quantity'];
}

if (is_customer() == true) {
	$cus_id = $_SESSION['customer_id'];
	$stmt = query("SELECT u1.name,c1.mobile_number,c1.email,c1.address,c1.city,c1.zipcode
    FROM users u1
    
    JOIN customers c1
    ON c1.user_id = u1.user_id
    WHERE c1.customer_id = {$cus_id}");
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$customer_name = $row['name'];
	$customer_mobile_number = $row['mobile_number'];
	$customer_address = $row['address'];
	$customer_email = $row['email'];
	$customer_city = $row['city'];
	$customer_zipcode = $row['zipcode'];
}

//generate unique pincodes and numbers
$order_pin_code = generatePinCode();
$identify_num = generateKey();
?>


<section class="ftco-section">
	<div class="container">
		<div class="row">
			<div class="col-xl-8 ftco-animate">
				<h1 style="text-align:center;font-size:24px">CHECKOUT</h1>

				<form action="checkout_hosted.php" method="post" class="p-3 billing-form ftco-bg-dark p-md-5">
					<h3 class="mb-4 billing-heading">Billing Details</h3>
					<div class="row align-items-end">

						<div class="col-md-12">
							<div class="form-group">
								<label for="firstname">Name</label>
								<input type="text" class="form-control" name="customer_name" value="<?php echo $customer_name; ?>" placeholder="Enter your name">
							</div>
						</div>


						<div class="w-100"></div>

						<div class="w-100"></div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="streetaddress">Street Address</label>
								<input type="text" class="form-control" name="customer_address" value="<?php echo $customer_address; ?>" placeholder="House number and street name">
							</div>
						</div>


						<div class="w-100"></div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="towncity">Town / City</label>
								<input type="text" class="form-control" name="customer_state" value="<?php echo $customer_city; ?>" placeholder="provide a valid state">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="postcodezip">Postcode / ZIP *</label>
								<input type="text" class="form-control" name="zip_code" value="<?php echo $customer_zipcode; ?>" placeholder="Zip code required.">
							</div>
						</div>

						<div class="w-100"></div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="phone">Phone</label>
								<input type="text" class="form-control" name="customer_mobile" value="<?php echo $customer_mobile_number; ?>" placeholder="Your Mobile number is required.">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="emailaddress">Email Address</label>
								<input type="text" class="form-control" name="customer_email" value="<?php echo $customer_email; ?>" placeholder="Please enter a valid email address">
							</div>
						</div>

						<div class="w-100"></div>

						<div class="custom-control custom-checkbox">

							<input type="hidden" value="<?php echo $item_quantity; ?>" name="items" required />
							<!-- amount (total amount => put the variable in value) -->
							<input type="hidden" value="<?php echo $item_total; ?>" name="amount" id="total_amount" required /> <!-- will be changed -->

							<input type="hidden" value="<?php echo $ship_date = date("Y-m-d H:i:s"); ?>" name="ship_date" id="total_amount" required />
							<input type="hidden" value="<?php echo $_SESSION['customer_id']; ?>" name="customer_id" id="cust_id" required />
							<input type="hidden" value="<?php echo $order_pin_code; ?>" name="customer_pin_code" id="cust_pin" required />
							<input type="hidden" value="<?php echo $identify_num; ?>" name="customer_identify_num" id="order_identify" required />

						</div>

						<button class="btn btn-primary btn-lg btn-block" type="submit">Place an Order</button>

					</div>
				</form>

				<div class="pt-3 mt-5 row d-flex">

					<div class="col-md-6 d-flex">
						<div class="p-3 cart-detail cart-total ftco-bg-dark p-md-4">
							<h3 class="mb-4 billing-heading">Cart Total</h3>

							<p class="d-flex">
								<span>Subtotal</span>
								<span>৳
									<?php
									//get total amount of cart --- stored in a session
									if (isset($_SESSION['item_total'])) {
										$item_total = $_SESSION['item_total'];
									} else {
										$item_total = $_SESSION['item_total'] = "0";
									}
									echo $item_total;
									?></span>
							</p>

							<p class="d-flex">
								<span>Quantity Bought</span>
								<span>
									<?php
									//get total number of items in cart --- stored in a session
									if (isset($_SESSION['item_quantity'])) {
										$item_quantity = $_SESSION['item_quantity'];
									} else {
										$item_quantity = $_SESSION['item_quantity'] = "0";
									}
									echo $item_quantity;
									?></span>
							</p>

							<p class="d-flex">
								<span>Discount</span>
								<span>৳<?php echo " " . $Discount; ?></span>
							</p>

							<hr>
							<p class="d-flex total-price">
								<span>Total</span>
								<span>৳
									<?php
									$Total_amount = $item_total - $Discount;
									echo $Total_amount;
									?></span>
							</p>

						</div>
					</div>

				</div>
			</div>


			<div class="col-xl-4 sidebar ftco-animate">

				<!-- Search bar -->
				<div class="sidebar-box">
					<form action="#" class="search-form">
						<div class="form-group">
							<div class="icon">
								<span class="icon-search"></span>
							</div>
							<input type="text" class="form-control" placeholder="Search...">
						</div>
					</form>
				</div>

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


</html>