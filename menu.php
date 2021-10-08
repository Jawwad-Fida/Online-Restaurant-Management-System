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
  <div class="slider-item" style="background-image: url(images/BGmenu.jpg);" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
      <div class="row slider-text justify-content-center align-items-center">
        <div class="text-center col-md-7 col-sm-12 ftco-animate">
          <h1 class="mt-5 mb-3 bread">Our Menu</h1>
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
              <h3>House:#, Road: #</h3>
              <p> Mohammadia Housing Society, Mohammadpur, Dhaka -1207</p>
            </div>
          </div>
          <div class="col-md-4 d-flex ftco-animate">
            <div class="icon"><span class="icon-clock-o"></span></div>
            <div class="text">
              <h3>Open 24/7</h3>
              <p>10.00 AM - 12.00 AM</p>
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

        <h3 style="text-align:center;">Reserve a Table</h3>

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


<section class="ftco-section">
  <div class="container">
    <div class="row">

      <div class="pb-3 mb-5 col-md-6">
        <h3 class="mb-5 heading-pricing ftco-animate">Starter</h3>

        <?php
        $result = query("SELECT * FROM food_items WHERE category_id=7 LIMIT 4");
        $stmt = $result;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $food_name = $row['food_name'];
          $short_description = $row['short_description'];
          $food_price =  $row['food_price'];
          $food_image =  $row['food_image'];

          //close php tag so that we can include some html inside the php while loop
        ?>

          <div class="pricing-entry d-flex ftco-animate">
            <div class="img"><img class="img-responsive" width="50" src="admin/<?php echo $food_image; ?>" alt="320x150"></div>
            <div class="pl-3 desc">
              <div class="d-flex text align-items-center">
                <h3><span><?php echo $food_name; ?></span></h3>
                <span class="price">৳<?php echo $food_price; ?></span>
              </div>
              <div class="d-block">
                <p><?php echo $short_description; ?></p>
              </div>
            </div>
          </div>

        <?php } ?>

      </div>

      <div class="pb-3 mb-5 col-md-6">
        <h3 class="mb-5 heading-pricing ftco-animate">Main Dish</h3>

        <?php
        $result = query("SELECT * FROM food_items WHERE category_id=9 LIMIT 4");
        $stmt = $result;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $food_name = $row['food_name'];
          $short_description = $row['short_description'];
          $food_price =  $row['food_price'];
          $food_image =  $row['food_image'];

          //close php tag so that we can include some html inside the php while loop
        ?>

          <div class="pricing-entry d-flex ftco-animate">
            <div class="img"><img class="img-responsive" width="50" src="admin/<?php echo $food_image; ?>" alt="320x150"></div>
            <div class="pl-3 desc">
              <div class="d-flex text align-items-center">
                <h3><span><?php echo $food_name; ?></span></h3>
                <span class="price">৳<?php echo $food_price; ?></span>
              </div>
              <div class="d-block">
                <p><?php echo $short_description; ?></p>
              </div>
            </div>
          </div>

        <?php } ?>

      </div>


      <div class="col-md-6">
        <h3 class="mb-5 heading-pricing ftco-animate">Desserts</h3>

        <?php
        $result = query("SELECT * FROM food_items WHERE category_id=8 LIMIT 4");
        $stmt = $result;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $food_name = $row['food_name'];
          $short_description = $row['short_description'];
          $food_price =  $row['food_price'];
          $food_image =  $row['food_image'];

          //close php tag so that we can include some html inside the php while loop
        ?>

          <div class="pricing-entry d-flex ftco-animate">
            <div class="img"><img class="img-responsive" width="50" src="admin/<?php echo $food_image; ?>" alt="320x150"></div>
            <div class="pl-3 desc">
              <div class="d-flex text align-items-center">
                <h3><span><?php echo $food_name; ?></span></h3>
                <span class="price">৳<?php echo $food_price; ?></span>
              </div>
              <div class="d-block">
                <p><?php echo $short_description; ?></p>
              </div>
            </div>
          </div>

        <?php } ?>

      </div>


      <div class="col-md-6">
        <h3 class="mb-5 heading-pricing ftco-animate">Drinks</h3>

        <?php
        $result = query("SELECT * FROM food_items WHERE category_id=1 LIMIT 4");
        $stmt = $result;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $food_name = $row['food_name'];
          $short_description = $row['short_description'];
          $food_price =  $row['food_price'];
          $food_image =  $row['food_image'];

          //close php tag so that we can include some html inside the php while loop
        ?>

          <div class="pricing-entry d-flex ftco-animate">
            <div class="img"><img class="img-responsive" width="50" src="admin/<?php echo $food_image; ?>" alt="320x150"></div>
            <div class="pl-3 desc">
              <div class="d-flex text align-items-center">
                <h3><span><?php echo $food_name; ?></span></h3>
                <span class="price">৳<?php echo $food_price; ?></span>
              </div>
              <div class="d-block">
                <p><?php echo $short_description; ?></p>
              </div>
            </div>
          </div>

        <?php } ?>

      </div>


    </div>
  </div>
</section>


<section class="pb-5 mb-5 ftco-menu">
  <div class="container">
    <div class="mb-5 row justify-content-center">
      <div class="text-center col-md-7 heading-section ftco-animate">
        <span class="subheading">Discover</span><br>
        <h2 class="mb-4">Our Products</h2>
        <p>We have got some super cool food items on our menu from the awesome chefs, only for you. Not only that, you can customize your item also. So waiting for what, let's go and grab the food you love.
        </p>
      </div>
    </div>

    <div class="row d-md-flex">
      <div class="col-lg-12 ftco-animate p-md-5">
        <div class="row">

          <div class="mb-5 col-md-12 nav-link-wrap">
            <div class="nav ftco-animate nav-pills justify-content-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">
              <a class="nav-link active" id="v-pills-1-tab" data-toggle="pill" href="#v-pills-1" role="tab" aria-controls="v-pills-1" aria-selected="true">Main Dish</a>
              <a class="nav-link" id="v-pills-2-tab" data-toggle="pill" href="#v-pills-2" role="tab" aria-controls="v-pills-2" aria-selected="false">Drinks</a>
              <a class="nav-link" id="v-pills-3-tab" data-toggle="pill" href="#v-pills-3" role="tab" aria-controls="v-pills-3" aria-selected="false">Desserts</a>
              <a class="nav-link" id="v-pills-4-tab" data-toggle="pill" href="#v-pills-4" role="tab" aria-controls="v-pills-4" aria-selected="false">Starters</a>
            </div>
          </div>

          <div class="col-md-12 d-flex align-items-center">
            <div class="tab-content ftco-animate" id="v-pills-tabContent">

              <div class="tab-pane fade show active" id="v-pills-1" role="tabpanel" aria-labelledby="v-pills-1-tab">
                <div class="row">

                  <!--------------------------------------------------------------- ---------------------------->

                  <?php
                  $result = query("SELECT * FROM food_items WHERE category_id=9");
                  $stmt = $result;

                  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $food_id = $row['food_id'];
                    $food_name = $row['food_name'];
                    $short_description = $row['short_description'];
                    $food_price =  $row['food_price'];
                    $food_image =  $row['food_image'];

                    //close php tag so that we can include some html inside the php while loop
                  ?>

                    <div class="text-center col-md-4">
                      <div class="menu-wrap">
                        <img class="img-responsive" width="200" src="admin/<?php echo $food_image; ?>" alt="320x150">
                        <div class="text">
                          <h3><a href="#"><?php echo $food_name; ?></a></h3>
                          <p><?php echo $short_description; ?></p>
                          <p class="price"><span>৳<?php echo $food_price; ?></span></p>
                          <p><a href="product-single.php?id=<?php echo $food_id; ?>" target="_blank" class="btn btn-primary btn-outline-primary">View Product</a>

                            <?php if ((is_logged_in() == true) && (is_customer() == true) ) : ?>
                              <a href="cart.php?add=<?php echo $food_id; ?>" target="_blank" class="btn btn-primary btn-outline-primary">Add to cart</a>
                            <?php endif; ?>

                            <?php if (is_logged_in() == false) : ?>
                              <a href="#" class="btn btn-danger">Login to add item to Cart!</a>
                            <?php endif; ?>

                          </p>


                        </div>
                      </div>
                    </div>

                  <?php } ?>


                </div>
              </div>


              <div class="tab-pane fade" id="v-pills-2" role="tabpanel" aria-labelledby="v-pills-2-tab">
                <div class="row">

                  <!--------------------------------------------------------------- ---------------------------->

                  <?php
                  $result = query("SELECT * FROM food_items WHERE category_id=1");
                  $stmt = $result;

                  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $food_id = $row['food_id'];
                    $food_name = $row['food_name'];
                    $short_description = $row['short_description'];
                    $food_price =  $row['food_price'];
                    $food_image =  $row['food_image'];

                    //close php tag so that we can include some html inside the php while loop
                  ?>

                    <div class="text-center col-md-4">
                      <div class="menu-wrap">
                        <img class="img-responsive" width="200" src="admin/<?php echo $food_image; ?>" alt="320x150">
                        <div class="text">
                          <h3><a href="#"><?php echo $food_name; ?></a></h3>
                          <p><?php echo $short_description; ?></p>
                          <p class="price"><span>৳<?php echo $food_price; ?></span></p>
                          <p><a href="product-single.php?id=<?php echo $food_id; ?>" target="_blank" class="btn btn-primary btn-outline-primary">View Product</a>

                            <?php if ((is_logged_in() == true) && (is_customer() == true)) : ?>
                              <a href="cart.php?add=<?php echo $food_id; ?>" target="_blank" class="btn btn-primary btn-outline-primary">Add to cart</a>
                            <?php endif; ?>

                            <?php if (is_logged_in() == false) : ?>
                              <a href="#" class="btn btn-danger">Login to add item to Cart!</a>
                            <?php endif; ?>

                          </p>
                        </div>
                      </div>
                    </div>

                  <?php } ?>


                </div>
              </div>


              <div class="tab-pane fade" id="v-pills-3" role="tabpanel" aria-labelledby="v-pills-3-tab">
                <div class="row">

                  <!--------------------------------------------------------------- ---------------------------->

                  <?php
                  $result = query("SELECT * FROM food_items WHERE category_id=8");
                  $stmt = $result;

                  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $food_id = $row['food_id'];
                    $food_name = $row['food_name'];
                    $short_description = $row['short_description'];
                    $food_price =  $row['food_price'];
                    $food_image =  $row['food_image'];

                    //close php tag so that we can include some html inside the php while loop
                  ?>

                    <div class="text-center col-md-4">
                      <div class="menu-wrap">
                        <img class="img-responsive" width="200" src="admin/<?php echo $food_image; ?>" alt="320x150">
                        <div class="text">
                          <h3><a href="#"><?php echo $food_name; ?></a></h3>
                          <p><?php echo $short_description; ?></p>
                          <p class="price"><span>৳<?php echo $food_price; ?></span></p>
                          <p><a href="product-single.php?id=<?php echo $food_id; ?>" target="_blank" class="btn btn-primary btn-outline-primary">View Product</a>

                            <?php if ((is_logged_in() == true) && (is_customer() == true)) : ?>
                              <a href="cart.php?add=<?php echo $food_id; ?>" target="_blank" class="btn btn-primary btn-outline-primary">Add to cart</a>
                            <?php endif; ?>

                            <?php if (is_logged_in() == false) : ?>
                              <a href="#" class="btn btn-danger">Login to add item to Cart!</a>
                            <?php endif; ?>

                          </p>
                        </div>
                      </div>
                    </div>

                  <?php } ?>

                </div>
              </div>

              <div class="tab-pane fade" id="v-pills-4" role="tabpanel" aria-labelledby="v-pills-4-tab">
                <div class="row">

                  <!--------------------------------------------------------------- ---------------------------->

                  <?php
                  $result = query("SELECT * FROM food_items WHERE category_id=7");
                  $stmt = $result;

                  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $food_id = $row['food_id'];
                    $food_name = $row['food_name'];
                    $short_description = $row['short_description'];
                    $food_price =  $row['food_price'];
                    $food_image =  $row['food_image'];

                    //close php tag so that we can include some html inside the php while loop
                  ?>

                    <div class="text-center col-md-4">
                      <div class="menu-wrap">
                        <img class="img-responsive" width="200" src="admin/<?php echo $food_image; ?>" alt="320x150">
                        <div class="text">
                          <h3><a href="#"><?php echo $food_name; ?></a></h3>
                          <p><?php echo $short_description; ?></p>
                          <p class="price"><span>৳<?php echo $food_price; ?></span></p>
                          <p><a href="product-single.php?id=<?php echo $food_id; ?>" target="_blank" class="btn btn-primary btn-outline-primary">View Product</a>

                            <?php if ((is_logged_in() == true) && (is_customer() == true)) : ?>
                              <a href="cart.php?add=<?php echo $food_id; ?>" target="_blank" class="btn btn-primary btn-outline-primary">Add to cart</a>
                            <?php endif; ?>

                            <?php if (is_logged_in() == false) : ?>
                              <a href="#" class="btn btn-danger">Login to add item to Cart!</a>
                            <?php endif; ?>

                          </p>
                        </div>
                      </div>
                    </div>

                  <?php } ?>


                </div>
              </div>


            </div>
          </div>
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