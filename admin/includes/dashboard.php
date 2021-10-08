<!-- /.row -->
<div class="row">

    <?php if (is_admin() == true) : ?>
        <div class="col-lg-4 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-shopping-cart fa-5x"></i>
                        </div>

                        <?php
                        $stmt = query("SELECT * FROM orders");
                        $rowNumber1 = count_records($stmt);
                        ?>

                        <div class="text-right col-xs-9">
                            <div class="huge"><?php echo $rowNumber1; ?></div>
                            <div>Orders!</div>
                        </div>
                    </div>
                </div>
                <!--
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
            -->
            </div>
        </div>


        <div class="col-lg-4 col-md-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-support fa-5x"></i>
                        </div>

                        <?php
                        $stmt = query("SELECT * FROM food_items");
                        $rowNumber2 = count_records($stmt);
                        ?>

                        <div class="text-right col-xs-9">
                            <div class="huge"><?php echo $rowNumber2; ?></div>
                            <div>Food Items!</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-tasks fa-5x"></i>
                        </div>

                        <?php
                        $stmt = query("SELECT * FROM category");
                        $rowNumber3 = count_records($stmt);
                        ?>

                        <div class="text-right col-xs-9">
                            <div class="huge"><?php echo $rowNumber3; ?></div>
                            <div>Categories!</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-4 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-file-text fa-5x"></i>
                        </div>

                        <?php
                        $stmt = query("SELECT * FROM reservation");
                        $rowNumber4 = count_records($stmt);
                        ?>

                        <div class="text-right col-xs-9">
                            <div class='huge'><?php echo $rowNumber4; ?></div>
                            <div>Reservations</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-4 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-comments fa-5x"></i>
                        </div>

                        <?php
                        $stmt = query("SELECT * FROM feedback");
                        $rowNumber5 = count_records($stmt);
                        ?>

                        <div class="text-right col-xs-9">
                            <div class='huge'><?php echo $rowNumber5; ?></div>
                            <div>Feedback</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-user fa-5x"></i>
                        </div>

                        <?php
                        $stmt = query("SELECT * FROM users");
                        $rowNumber6 = count_records($stmt);
                        ?>

                        <div class="text-right col-xs-9">
                            <div class='huge'><?php echo $rowNumber6; ?></div>
                            <div> Users</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

<!-- -------------------------------------------------------------------------------------------- -->

    <?php if (is_customer() == true) : ?>
        <?php $customer_id = $_SESSION['customer_id']; ?>
        <div class="col-lg-4 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-shopping-cart fa-5x"></i>
                        </div>

                        <?php
                        $stmt = query("SELECT * FROM orders WHERE cus_id={$customer_id}");
                        $rowNumber1 = count_records($stmt);
                        ?>

                        <div class="text-right col-xs-9">
                            <div class="huge"><?php echo $rowNumber1; ?></div>
                            <div>Orders!</div>
                        </div>
                    </div>
                </div>
                <!--
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
            -->
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-file-text fa-5x"></i>
                        </div>

                        <?php
                        $stmt = query("SELECT * FROM reservation WHERE cust_id={$customer_id}");
                        $rowNumber4 = count_records($stmt);
                        ?>

                        <div class="text-right col-xs-9">
                            <div class='huge'><?php echo $rowNumber4; ?></div>
                            <div>Reservations</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-4 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-comments fa-5x"></i>
                        </div>

                        <?php
                        $stmt = query("SELECT * FROM feedback WHERE cust_id={$customer_id}");
                        $rowNumber5 = count_records($stmt);
                        ?>

                        <div class="text-right col-xs-9">
                            <div class='huge'><?php echo $rowNumber5; ?></div>
                            <div>Feedback</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>

</div>

<!-- /.row -->