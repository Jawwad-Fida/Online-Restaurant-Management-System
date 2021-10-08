<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->

    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">User Panel</a>
    </div>


    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">

        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i><?php echo $_SESSION['username']; ?><b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li>
                    <a href="../index.php"><i class="fa fa-home fa-fw"></i> Home Page</a>
                </li>

                <?php if ((is_customer() == true) || is_driver() == true) : ?>
                    <li>
                        <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                    </li>
                <?php endif; ?>


                <li class="divider"></li>
                <li>
                    <a href="../includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                </li>
            </ul>
        </li>
    </ul>


    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">

            <?php if (is_admin() == true) : ?>
                <li class="">
                    <a href="admin_dashboard.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard: Graphical</a>
                </li>
            <?php endif; ?>

            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#demo3"><i class="fa fa-fw fa-bar-chart-o"></i> View Orders <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="demo3" class="collapse">

                    <?php if (is_driver() == true) : ?>
                        <li>
                            <a href="unassigned_orders.php"> Accept delivery </a>
                        </li>
                    <?php endif; ?>

                    <?php if ((is_driver() == true) || (is_customer() == true) || (is_admin() == true)) : ?>
                        <li>
                            <a href="assigned_orders.php"> In Progress </a>
                        </li>
                    <?php endif; ?>

                    <?php if ((is_driver() == true) || (is_customer() == true) || (is_admin() == true)) : ?>
                        <li>
                            <a href="delivered_orders.php"> Completed Orders </a>
                        </li>
                    <?php endif; ?>

                </ul>
            </li>

            <?php if ((is_customer() == true) || (is_admin() == true)) : ?>
                <li>
                    <a href="payment_details.php"><i class="fa fa-credit-card"></i> Payment Details</a>
                </li>
            <?php endif; ?>

            <?php if (is_admin() == true) : ?>
                <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#demo1"><i class="fa fa-users"></i> View Users <i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="demo1" class="collapse">
                        <li>
                            <a href="users_admin.php"> Admins </a>
                        </li>
                        <li>
                            <a href="users_customer.php"> Customers </a>
                        </li>
                        <li>
                            <a href="users_driver.php"> Driver </a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if (is_admin() == true) : ?>
                <li>
                    <a href="add_users.php"><i class="fa fa-user"></i> Add Users</a>
                </li>
            <?php endif; ?>

            <?php if ((is_admin() == true) || (is_customer() == true)) : ?>
                <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#demo2"><i class="fa fa-database"></i> Food Items <i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="demo2" class="collapse">
                        <li>
                            <a href="choose_fooditem.php"> View Food Items </a>
                        </li>

                        <?php if (is_admin() == true) : ?>
                            <li>
                                <a href="add_fooditem.php">Add Food items</a>
                            </li>
                        <?php endif; ?>

                    </ul>
                </li>
            <?php endif; ?>


            <?php if (is_admin() == true) : ?>
                <li>
                    <a href="categories.php"><i class="fa fa-fw fa-table"></i> Categories</a>
                </li>
            <?php endif; ?>


            <?php if ((is_admin() == true) || (is_customer() == true)) : ?>
                <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#demo4"><i class="fa fa-cutlery"></i> Reservations <i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="demo4" class="collapse">
                        <li>
                            <a href="reservation_pending.php">Pending Reservations</a>
                        </li>
                        <li>
                            <a href="reservation_success.php">Success Reservations</a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if (is_admin() == true) : ?>
                <li>
                    <a href="feedback.php"><i class="fa fa-comment-o"></i> Customer Feedback</a>
                </li>
            <?php endif; ?>

        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>