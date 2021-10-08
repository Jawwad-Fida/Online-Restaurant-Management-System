<!DOCTYPE html>
<html lang="en">

<?php
include('header.php');
?>

<?php
include('navigation.php');
?>

<?php

//======================================== Cart Functions ============================================

function display_cart()
{
  $total = 0;
  $item_quantity = 0;

  //operation on session variable (associative array) => $name = session name, $value = session data
  foreach ($_SESSION as $name => $value) {

    if ($value > 0) { //preventing multiple data to be shown

      //grab the session that we need
      //start at 0th character till 8th 
      if (substr($name, 0, 8) == "product_") {

        //pull product_id(session id) out of session
        $length = strlen($name) - 8;
        $id = substr($name, 8, $length);

        //$value contains the quantity of the item added i.e. (1,2,3,..)

        $stmt = query("SELECT * FROM food_items WHERE food_id={$id}");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

          //find sub-total of items 
          $sub = $row['food_price'] * $value;

          //find total no.of items
          $item_quantity += $value;

          echo "
                    <tr class='text-center'>
                      <td class='product-remove'>
                          <a href='cart.php?delete={$row['food_id']}'><span class='icon-close'></span></a>&nbsp;&nbsp;
                      </td>

                      <td class='image-prod'>
                          <div class='img'><img class='img-responsive' width='90' src='admin/{$row['food_image']}' alt='320x150'></div>
                      </td>
                
                      <td class='product-name'>
                          <h3>{$row['food_name']}</h3>
                          <p>{$row['short_description']}</p>
                      </td>

                      <td class='price'>৳ {$row['food_price']}</td>
                      <td class='price'>{$value}</td>
                      <td class='total'>৳ {$sub}</td>
                
                      <td class='product-remove'>
                      <a href='cart.php?add={$row['food_id']}'><span class='icon-add'></span></a>&nbsp;&nbsp;
                      <a href='cart.php?remove={$row['food_id']}'><span class='icon-minus'></span></a>&nbsp;&nbsp;
                      </td>
                    </tr>
                    ";

        }

        //grab the sub-totals to calculate total amount
        $total += $sub;
        $_SESSION['item_total'] = $total;

        //grab the total no.of items
        $_SESSION['item_quantity'] =  $item_quantity;
      }
    }
  }
}


function cart_system()
{
  //Detect product_id from url

  if (isset($_GET['add'])) {

    //--------ADD ITEM TO CART----------

    $stmt = query("SELECT * FROM food_items WHERE food_id={$_GET['add']}");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

      //if we have item available, then add it to cart 
      if ($row['quantity'] != $_SESSION['product_' . $_GET['add']]) { //create dynamic session - using id
        //join product_id to session, and
        //increment item

        $_SESSION['product_' . $_GET['add']] += 1;
        redirect("cart.php?success=item_add");
      } else {
        //if we dont have the item available (quantity=0), prevent adding to cart
        redirect("cart.php?error=not_available");
      }
    }
  }


  if (isset($_GET['remove'])) {

    //--------Remove ITEM FROM CART----------

    //if nothing is in cart, remove won't work
    if ($_SESSION['product_' . $_GET['remove']] < 1) {
      redirect("cart.php?error=cart_empty");
    } else {
      //item is in cart, remove item
      $_SESSION['product_' . $_GET['remove']] -= 1;

      if ($_SESSION['product_' . $_GET['remove']] < 1) {
        //when cart becomes empty - unset cart values (sessions)
        unset($_SESSION['item_total']);
        unset($_SESSION['item_quantity']);
      }
      redirect("cart.php?success=item_removed");
    }
  }


  if (isset($_GET['delete'])) {

    //--------DELETE ITEM FROM CART----------

    $_SESSION['product_' . $_GET['delete']] = '0'; //'0' has to be string

    //unset cart values (sessions) - when cart becomes empty
    unset($_SESSION['item_total']);
    unset($_SESSION['item_quantity']);

    redirect("cart.php?success=item_deleted");
  }

  display_cart();
}

//fixed variables
$Total_amount = 0;
$Discount = 0;
$Delivery_charge = 50;
$Vat = 100;
?>



<section class="ftco-section ftco-cart">

  <div class="container">
    <div class="row">

      <div class="col-md-12 ftco-animate">
        <div class="cart-list">
          <table class="table">


            <thead class="thead-primary">
              <tr class="text-center">
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
              </tr>
            </thead>

            <tbody>
              <?php cart_system(); ?>
            </tbody>


          </table>
        </div>
      </div>

    </div>


    <div class="row justify-content-end">
      <div class="mt-5 col col-lg-3 col-md-6 cart-wrap ftco-animate">
        <div class="mb-3 cart-total">

          <h3>Cart Totals</h3>

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
              $Total_amount = $item_total + $Delivery_charge - $Discount + $Vat;
              echo $item_total;
              $_SESSION["total_amount"] = $Total_amount;
              ?></span>
          </p>

        </div>

        <?php if (is_logged_in() == true) : ?>
          <p class="text-center"><a href="checkout.php" class="px-4 py-3 btn btn-primary">Proceed to Checkout</a></p>
        <?php endif; ?>

        <?php if (is_logged_in() == false) : ?>
          <p class="text-center"><a href="#" class="px-4 py-3 btn btn-danger">Login to Add Items to Cart!</a></p>
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