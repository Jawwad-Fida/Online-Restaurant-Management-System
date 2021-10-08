<!DOCTYPE html>
<html lang="en">

<?php
include('header.php');
?>

<?php
include('navigation.php');
?>

<?php
if (is_customer() == true) {
  $cus_id = $_SESSION['customer_id'];
  $stmt = query("SELECT u1.name,c1.mobile_number,c1.email
    FROM users u1
    
    JOIN customers c1
    ON c1.user_id = u1.user_id
    WHERE c1.customer_id = {$cus_id}");
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $current_name = $row['name'];
  $current_mobile_number = $row['mobile_number'];
  $current_email = $row['email'];
}
?>


<section class="home-slider owl-carousel">

  <div class="slider-item" style="background-image: url(images/BGM1.jpg);">
    <div class="overlay"></div>
    <div class="container">
      <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">
        <div class="text-center col-md-8 col-sm-12 ftco-animate">
          <span class="subheading">Welcome</span>
          <h1 class="mb-4">The Best Online Restaurent</h1>
          <p class="mb-4 mb-md-5">Great place to eat in your neighbourhood.</p>
          <p><a href="menu.php" class="p-3 btn btn-primary px-xl-4 py-xl-3">Order Now</a></p>
        </div>
      </div>
    </div>
  </div>

  <div class="slider-item" style="background-image: url(images/BGM2.jpg);">
    <div class="overlay"></div>
    <div class="container">
      <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">
        <div class="text-center col-md-8 col-sm-12 ftco-animate">
          <span class="subheading">Welcome</span>
          <h1 class="mb-4">Amazing Taste &amp; Beautiful Place</h1>
          <p class="mb-4 mb-md-5">Order our amazing dishes.</p>
          <p><a href="menu.php" class="p-3 btn btn-primary px-xl-4 py-xl-3">Order Now</a></p>
        </div>
      </div>
    </div>
  </div>

  <div class="slider-item" style="background-image: url(images/BGM3.jpg);">
    <div class="overlay"></div>
    <div class="container">
      <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">
        <div class="text-center col-md-8 col-sm-12 ftco-animate">
          <span class="subheading">Welcome</span>
          <h1 class="mb-4">Creamy Hot and Ready to Serve</h1>
          <p class="mb-4 mb-md-5">Enjoy your foods with your freinds and family.</p>
          <p><a href="menu.php" class="p-3 btn btn-primary px-xl-4 py-xl-3">Order Now</a></p>
        </div>
      </div>
    </div>
  </div>
</section>



<section class="ftco-intro">
  <div class="container-wrap">
    <div class="wrap d-md-flex align-items-xl-end">
      <div class="info">
        <div class="row no-gutters">
          <div class="col-md-4 d-flex ftco-animate">
            <div class="icon"><span class="icon-phone"></span></div>
            <div class="text">
              <h3>+880 1234 56789</h3>
              <p>24/7 Available.</p>
            </div>
          </div>
          <div class="col-md-4 d-flex ftco-animate">
            <div class="icon"><span class="icon-my_location"></span></div>
            <div class="text">
              <h3>House:#, Road:#</h3>
              <p>Mohammadia Housing Society,Mohammadpur,Dhaka-1207</p>
            </div>
          </div>
          <div class="col-md-4 d-flex ftco-animate">
            <div class="icon"><span class="icon-clock-o"></span></div>
            <div class="text">
              <h3>Open 24/7</h3>
              <p>10:00am - 12:00pm</p>
            </div>
          </div>
        </div>
      </div>

      <!------------------ Reservation/Booking (OTP system) ------------------>
      <div class="p-4 book">

        <!-- Display error messages -->
        <?php display_error_message(); ?>

        <!-- Display success messages -->
        <?php display_success_message(); ?>

        <h3>Reserve a Table</h3>

        <?php if (is_customer() == true) : ?>

          <form action="reservation.php" method="post" class="appointment-form">

            <div class="d-md-flex">

              <div class="form-group">
                <input type="text" class="form-control" name="name" value="<?php echo $current_name; ?>">
              </div>

              <div class="form-group ml-md-4">
                <input type="text" class="form-control" name="persons_reserved" placeholder="No. of persons reserved">
              </div>

            </div>

            <div class="d-md-flex">

              <div class="form-group">
                <div class="input-wrap">
                  <div class="icon"><span class="ion-md-calendar"></span></div>
                  <input type="text" class="form-control appointment_date" min="2021-01-01" max="2021-12-31" name="reserve_date" placeholder="Date">
                </div>
              </div>

              <div class="form-group ml-md-4">
                <div class="input-wrap">
                  <div class="icon"><span class="ion-ios-clock"></span></div>
                  <input type="text" class="form-control appointment_time" min="09:00" max="21:00" name="reserve_time" placeholder="Time">
                </div>
              </div>

              <div class="form-group ml-md-4">
                <input type="text" class="form-control" name="number" value="<?php echo $current_mobile_number; ?>">
              </div>

            </div>

            <div class="d-md-flex">
              <div class="form-group">
                <textarea name="message" id="" cols="30" rows="2" class="form-control" placeholder="Message"></textarea>
              </div>


              <div class="form-group ml-md-4">
                <input type="submit" name="reserve_submit" value="Appointment" class="px-4 py-3 btn btn-white">
              </div>

            </div>
          </form>
        <?php endif; ?>

        <?php if (is_customer() == false) : ?>
          <div class="form-group ml-md-4">
            <p style='color:black;font-size:20px'>Please,login to reserve your table and have a great dine in service with your loved ones!
            <p>
          </div>
        <?php endif; ?>

      </div>


    </div>
  </div>

</section>


<section class="ftco-about d-md-flex">
  <div class="one-half img" style="background-image: url(images/welcome.jpg);"></div>
  <div class="one-half ftco-animate">
    <div class="overlap">
      <div class="heading-section ftco-animate ">
        <span class="subheading">Discover</span>
        <h2 class="mb-4">Our Story</h2>
      </div>
      <div>
        <p>We are the first Bangladeshi Online Restaurant chain that specializes in fast food such as Naga Wings Barrel,
          Potato Wedges, and peri-peri style chicken dishes. We are Bangladeshi fast-food company, founded on
          14th April 2021 as a restaurant operated by Sayeda Muntaha Ferdous & Jawwad Ul Islam Fida, in Mohammadpur, Dhaka, Bangladesh.
          Our original headquarters in Bashundhara, Dhaka called Club House Branch..</p>
      </div>
    </div>
  </div>
</section>

<section class="ftco-section ftco-services">
  <div class="container">
    <div class="row">
      <div class="col-md-4 ftco-animate">
        <div class="text-center media d-block block-6 services">
          <div class="mb-5 icon d-flex justify-content-center align-items-center">
            <span class="flaticon-choices"></span>
          </div>
          <div class="media-body">
            <h3 class="heading">Easy to Order</h3>
            <p>Your order a just a click away.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4 ftco-animate">
        <div class="text-center media d-block block-6 services">
          <div class="mb-5 icon d-flex justify-content-center align-items-center">
            <span class="flaticon-delivery-truck"></span>
          </div>
          <div class="media-body">
            <h3 class="heading">Fastest Delivery</h3>
            <p>You will have your delivery so fast that you can't imagine.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4 ftco-animate">
        <div class="text-center media d-block block-6 services">
          <div class="mb-5 icon d-flex justify-content-center align-items-center">
            <span class="flaticon-coffee-bean"></span>
          </div>
          <div class="media-body">
            <h3 class="heading">Quality Food</h3>
            <p>We always maintain the quality of our ingredients and food items.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="ftco-section">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6 pr-md-5">
        <div class="heading-section text-md-right ftco-animate">
          <span class="subheading">Discover</span>
          <h2 class="mb-4">Our Menu</h2>
          <p class="mb-4">We have got some super cool food items on our menu from the awesome chefs, only for you. Not only that, you can customize your item also. So waiting for what, let's go and grab the food you love. </p>
          <p><a href="menu.php" class="px-4 py-3 btn btn-primary btn-outline-primary">View Full Menu</a></p>
        </div>
      </div>
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-6">
            <div class="menu-entry">
              <a href="#" class="img" style="background-image: url(images/image_3.jpg);"></a>
            </div>
          </div>
          <div class="col-md-6">
            <div class="menu-entry mt-lg-4">
              <a href="#" class="img" style="background-image: url(images/image_1.jpg);"></a>
            </div>
          </div>
          <div class="col-md-6">
            <div class="menu-entry">
              <a href="#" class="img" style="background-image: url(images/coffee.jpg);"></a>
            </div>
          </div>
          <div class="col-md-6">
            <div class="menu-entry mt-lg-4">
              <a href="#" class="img" style="background-image: url(images/drink-1.jpg);"></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="ftco-counter ftco-bg-dark img" id="section-counter" style="background-image: url(images/BOGO.png);" data-stellar-background-ratio="0.5">
  <div class="overlay"></div>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <div class="row">
          <div class="col-md-6 col-lg-4 d-flex justify-content-center counter-wrap ftco-animate">
            <div class="text-center block-18">
              <div class="text">
                <div class="icon"><span class="flaticon-coffee-cup"></span></div>
                <?php
                $stmt = query("SELECT * FROM food_items");
                $rowNumber2 = count_records($stmt);
                ?>

                <strong class="number"><?php echo $rowNumber2; ?></strong>
                <span>Food Items</span>
              </div>
            </div>
          </div>

          <div class="col-md-6 col-lg-4 d-flex justify-content-center counter-wrap ftco-animate">
            <div class="text-center block-18">
              <div class="text">
                <div class="icon"><span class="flaticon-coffee-cup"></span></div>

                <?php
                $stmt = query("SELECT * FROM customers");
                $rowNumber6 = count_records($stmt);
                ?>

                <strong class="number"><?php echo $rowNumber6; ?></strong>
                <span>Customers</span>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 d-flex justify-content-center counter-wrap ftco-animate">
            <div class="text-center block-18">
              <div class="text">
                <div class="icon"><span class="flaticon-coffee-cup"></span></div>

                <?php
                $stmt = query("SELECT * FROM category");
                $rowNumber3 = count_records($stmt);
                ?>

                <strong class="number"><?php echo $rowNumber3; ?></strong>
                <span>Categories</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="ftco-gallery">
  <div class="container-wrap">
    <div class="row no-gutters">
      <div class="col-md-3 ftco-animate">
        <a href="#" class="gallery img d-flex align-items-center" style="background-image: url(images/image_2.jpg);">
          <div class="mb-4 icon d-flex align-items-center justify-content-center">
            <span class="icon-search"></span>
          </div>
        </a>
      </div>
      <div class="col-md-3 ftco-animate">
        <a href="#" class="gallery img d-flex align-items-center" style="background-image: url(images/drink-7.jpg);">
          <div class="mb-4 icon d-flex align-items-center justify-content-center">
            <span class="icon-search"></span>
          </div>
        </a>
      </div>
      <div class="col-md-3 ftco-animate">
        <a href="#" class="gallery img d-flex align-items-center" style="background-image: url(images/french.jpg);">
          <div class="mb-4 icon d-flex align-items-center justify-content-center">
            <span class="icon-search"></span>
          </div>
        </a>
      </div>
      <div class="col-md-3 ftco-animate">
        <a href="#" class="gallery img d-flex align-items-center" style="background-image: url(images/menu-4.jpg);">
          <div class="mb-4 icon d-flex align-items-center justify-content-center">
            <span class="icon-search"></span>
          </div>
        </a>
      </div>
    </div>
  </div>
</section>


<section class="ftco-section img" id="ftco-testimony" style="background-image: url(images/BGM1.jpg);" data-stellar-background-ratio="0.5">
  <div class="overlay"></div>
  <div class="container">
    <div class="mb-5 row justify-content-center">
      <div class="text-center col-md-7 heading-section ftco-animate">
        <span class="subheading">Testimony</span>
        <h2 class="mb-4">Customers Says</h2>
        <p>See what our lovely customers are saying about our food..</p>
      </div>
    </div>
  </div>

  <div class="container-wrap">

    <div class="row d-flex no-gutters">

      <?php
      //join query feedback with customers on basis of cus_id
      $stmt = query("SELECT c1.username, f1.service, u1.user_image
      FROM feedback f1
      
      JOIN customers c1
      ON c1.customer_id = f1.cust_id
      
      JOIN users u1
      ON u1.user_id = c1.user_id
      
      LIMIT 5");

      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $user_image = $row['user_image'];
        $username = $row['username'];
        $service =  $row['service'];

      ?>
        <div class="col-lg align-self-sm-end ftco-animate">
          <div class="testimony">
            <blockquote>
              <p>&ldquo;<?php echo $service; ?>&rdquo;</p>
            </blockquote>
            <div class="mt-4 author d-flex">
              <div class="mr-3 image align-self-center">
                <img class="img-responsive" src="admin/<?php echo $user_image; ?>" alt="320x150">
              </div>
              <div class="name align-self-center"><?php echo $username; ?></div>
            </div>
          </div>
        </div>

      <?php } ?>


    </div>
  </div>
</section>


<section class="ftco-appointment">
  <div class="overlay"></div>
  <div class="container-wrap">
    <div class="row no-gutters d-md-flex align-items-center">
      <div class="col-md-6 d-flex align-self-stretch">
        <div id="map">
          <p><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3651.5417617601875!2d90.35316176445613!3d23.76371494418561!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c09ffaffd459%3A0x8268e2507d87e477!2sMohammadia%20Housing%20Society%2C%20Dhaka!5e0!3m2!1sen!2sbd!4v1621576102615!5m2!1sen!2sbd" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe></p>
        </div>
      </div>

      <!------------------ Reservation/Booking (OTP system) ------------------>

      <div class="col-md-6 appointment ftco-animate">

        <!-- Display error messages -->
        <?php display_error_message(); ?>

        <!-- Display success messages -->
        <?php display_success_message(); ?>

        <h3 class="mb-3">Reserve a Table</h3>

        <?php if (is_customer() == true) : ?>

          <form action="reservation.php" method="post" class="appointment-form">

            <div class="d-md-flex">

              <div class="form-group">
                <input type="text" class="form-control" name="name" value="<?php echo $current_name; ?>">
              </div>

              <div class="form-group ml-md-4">
                <input type="text" class="form-control" name="persons_reserved" placeholder="No. of persons reserved">
              </div>

            </div>

            <div class="d-md-flex">

              <div class="form-group">
                <div class="input-wrap">
                  <div class="icon"><span class="ion-md-calendar"></span></div>
                  <input type="text" class="form-control appointment_date" min="2021-01-01" max="2021-12-31" name="reserve_date" placeholder="Date">
                </div>
              </div>

              <div class="form-group ml-md-4">
                <div class="input-wrap">
                  <div class="icon"><span class="ion-ios-clock"></span></div>
                  <input type="text" class="form-control appointment_time" min="09:00" max="21:00" name="reserve_time" placeholder="Time">
                </div>
              </div>

              <div class="form-group ml-md-4">
                <input type="text" class="form-control" name="number" value="<?php echo $current_mobile_number; ?>">
              </div>

            </div>

            <div class="d-md-flex">

              <div class="form-group">
                <textarea name="message" cols="30" rows="2" class="form-control" placeholder="Message"></textarea>
              </div>

              <div class="form-group ml-md-4">
                <input type="submit" name="reserve_submit" value="Appointment" class="px-4 py-3 btn btn-white">
              </div>

            </div>

          </form>
        <?php endif; ?>

        <?php if (is_customer() == false) : ?>
          <div class="form-group ml-md-4">
            <p style='color:white;font-size:20px'>Please,login to reserve your table and have a great dine in service with your loved ones!
            <p>
          </div>
        <?php endif; ?>

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
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&amp;sensor=false"></script> -->
<script src="js/google-map.js"></script>
<script src="js/main.js"></script>

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<script>
  window.dataLayer = window.dataLayer || [];

  function gtag() {
    dataLayer.push(arguments);
  }
  gtag('js', new Date());

  gtag('config', 'UA-23581568-13');
</script>
<script defer src="../../../static.cloudflareinsights.com/beacon.min.js" data-cf-beacon='{"version":"2021.4.0","si":10,"rayId":"641f495b8c30d9cc"}'></script>
</body>

</html>