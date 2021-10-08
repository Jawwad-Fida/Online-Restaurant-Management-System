<!DOCTYPE html>
<html lang="en">

<?php
include('header.php');
?>

<?php
include('navigation.php');
?>

<?php

if (isset($_GET['id'])) {
	$the_food_id = $_GET['id'];

	$stmt = query("SELECT * FROM food_items WHERE food_id={$the_food_id}");

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$food_id = $row['food_id'];
		$the_category_id = $row['category_id'];
		$food_name = $row['food_name'];
		$quantity = $row['quantity'];
		$short_description = $row['short_description'];
		$food_price =  $row['food_price'];
		$food_image =  $row['food_image'];
	}
}
?>





<section class="home-slider owl-carousel">
	<div class="slider-item" style="background-image: url(images/menu.jpg);" data-stellar-background-ratio="0.5">
		<div class="overlay"></div>
		<div class="container">
			<div class="row slider-text justify-content-center align-items-center">
				<div class="text-center col-md-7 col-sm-12 ftco-animate">
					<h1 class="mt-5 mb-3 bread">Product Detail</h1>
				</div>
			</div>
		</div>
	</div>
</section>


<section class="ftco-section">
	<div class="container">
		<div class="row">


			<div class="mb-5 col-lg-6 ftco-animate">
				<a href="admin/<?php echo $food_image; ?>" class="image-popup"><img src="admin/<?php echo $food_image; ?>" class="img-fluid" alt="Colorlib Template"></a>
			</div>
			<div class="col-lg-6 product-details pl-md-5 ftco-animate">

				<h3><?php echo $food_name; ?></h3>
				<p class="price"><span>৳<?php echo $food_price; ?></span></p>
				<p><?php echo $short_description; ?></p>
				<p><a href="#">Quantity Available : </a><?php echo $quantity; ?></p>
				<div class="mt-4 row">

					<!-- Customization -->

					<div class="col-md-6">
						<div class="form-group d-flex">
							<div class="select-wrap">
								<div class="icon"><span class="ion-ios-arrow-down"></span></div>
								<select name="" id="" class="form-control">
									<option value="">Small</option>
									<option value="">Medium</option>
									<option value="">Large</option>
									<option value="">Extra Large</option>
								</select>
							</div>
						</div>
					</div>

					<div class="w-100"></div>

				</div>

				<?php if (is_logged_in() == true) : ?>
					<p><a href="cart.php?add=<?php echo $food_id; ?>" target="_blank" class="px-5 py-3 btn btn-primary">Add to Cart</a></p>
				<?php endif; ?>

				<?php if (is_logged_in() == false) : ?>
					<p><a href="#" class="px-5 py-3 btn btn-danger">Login to Add item to Cart!</a></p>
				<?php endif; ?>

			</div>


		</div>
	</div>
</section>



<section class="ftco-section">
	<div class="container">

		<div class="pb-3 mb-5 row justify-content-center">
			<div class="text-center col-md-7 heading-section ftco-animate">
				<span class="subheading">Discover</span><br>
				<h2 class="mb-4">Related products</h2>
			</div>
		</div>

		<div class="row">

			<?php
			$result = query("SELECT * FROM food_items WHERE category_id={$the_category_id}");
			$stmt = $result;

			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$another_food_id = $row['food_id'];
				$food_name = $row['food_name'];
				$short_description = $row['short_description'];
				$food_price =  $row['food_price'];
				$food_image =  $row['food_image'];

				//close php tag so that we can include some html inside the php while loop
			?>

				<div class="col-md-3">
					<div class="menu-entry">
						<img class="img-responsive" width="200" src="admin/<?php echo $food_image; ?>" alt="320x150">
						<div class="pt-4 text-center text">
							<h3><a href="#"><?php echo $food_name; ?></a></h3>
							<p><?php echo $short_description; ?></p>
							<p class="price"><span>৳<?php echo $food_price; ?></span></p>
							<p><a href="product-single.php?id=<?php echo $another_food_id; ?>" target="_blank" class="btn btn-primary btn-outline-primary">View Product</a> 
						</div>
					</div>
				</div>

			<?php } ?>


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

<!-- Mirrored from preview.colorlib.com/theme/coffeeblend/product-single.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 18 Apr 2021 16:32:50 GMT -->

</html>