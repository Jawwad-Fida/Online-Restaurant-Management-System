<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">

    <div class="container">

        <a class="navbar-brand" href="index.php">Cuisine <small>Catered</small></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>
        
        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="ml-auto navbar-nav">
                <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="menu.php" class="nav-link">Menu</a></li>

                <?php if (is_logged_in() == false) : ?>
                <li class="nav-item"><a href="registration.php" class="nav-link">Registration</a></li>
                <?php endif; ?>
                
                <?php if (is_logged_in() == true) : ?>
                <li class="nav-item"><a href="admin/index.php" class="nav-link">User Panel</a></li>
                <?php endif; ?>

                <?php if (is_logged_in() == false) : ?>
                <li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>
                <?php endif; ?>

                <?php if ((is_logged_in() == true) && (is_admin() == true) ) : ?>
                <li class="nav-item"><a href="inventory/index.php" class="nav-link">Inventory</a></li>
                <?php endif; ?>
                
                <?php if ((is_logged_in() == true) && (is_customer() == true) ) : ?>
                <li class="nav-item"><a href="cart.php" class="nav-link">Cart</a></li>
                <?php endif; ?>

                <?php if (is_logged_in() == true) : ?>
                <li class="nav-item"><a href="includes/logout.php" class="nav-link">Logout</a></li>
                <?php endif; ?>

                
                <?php if (is_customer() == true) : ?>
                <li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>
                <?php endif; ?>
                
                <li class="nav-item cart"><a href="cart.php" class="nav-link"><span class="icon icon-shopping_cart"></span><span class="bag d-flex justify-content-center align-items-center"><small>
                <?php
                echo isset($_SESSION['item_quantity']) ? $_SESSION['item_quantity'] : $_SESSION['item_quantity'] = "0";   
                ?>
                </small></span></a></li>

            </ul>
        </div>

    </div>

</nav>

