<?php
//we will make this page dynamic - i.e. it will change according to data
include "includes/header.php";
?>

<div id="wrapper">

    <?php
    //we will make this page dynamic - i.e. it will change according to data
    include "includes/navigation.php";
    ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">

                    <h1 class="page-header">
                        Graphical Dashboard
                    </h1>

                </div>
            </div>
            <!-- /.row -->

            <?php
            //GET DYNAMIC DATA FROM DATABASE TABLES TO PUBLISH ON CHARTS ----- GOOGLE CHARTS API

            $stmt = query("SELECT * FROM users WHERE user_role='admin'");
            $admin_count = count_records($stmt);

            $stmt = query("SELECT * FROM users WHERE user_role='customer'");
            $customer_count = count_records($stmt);

            $stmt = query("SELECT * FROM users WHERE user_role='driver'");
            $driver_count = count_records($stmt);

            // -------------------------------------------------------

            $stmt = query("SELECT * FROM orders WHERE delivery_status='Delivered'");
            $deliver_count = count_records($stmt);

            $stmt = query("SELECT * FROM orders WHERE delivery_status='On The Way'");
            $on_way_count = count_records($stmt);

            $stmt = query("SELECT * FROM orders WHERE status='Success'");
            $success_count = count_records($stmt);

            //--------------------------------------------------------

            $stmt = query("SELECT * FROM food_items WHERE category_id=1");
            $category_count_1 = count_records($stmt);

            $stmt = query("SELECT * FROM food_items WHERE category_id=7");
            $category_count_2 = count_records($stmt);

            $stmt = query("SELECT * FROM food_items WHERE category_id=8");
            $category_count_3 = count_records($stmt);

            $stmt = query("SELECT * FROM food_items WHERE category_id=9");
            $category_count_4 = count_records($stmt);

            ?>


            <!-------------- USING GOOGLE API CHARTS -------------->


            <!------- FIRST CHART (Orders) ------>
            <div class="row">

                <script type="text/javascript">
                    google.load("visualization", "1.1", {
                        packages: ["bar"]
                    });
                    google.setOnLoadCallback(drawChart);

                    function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                            ['Data', 'Numbers'],

                            <?php

                            $element_text = array('Delivered', 'On The Way', 'Success');
                            $element_count = array($deliver_count, $on_way_count, $success_count);

                            $size_of_array = sizeof($element_count);

                            for ($i = 0; $i < $size_of_array; $i++) {

                                echo "['{$element_text[$i]}'" . "," . "{$element_count[$i]}],";
                                // Like ['2017', 1030],
                            }

                            ?>

                        ]);

                        var options = {
                            chart: {
                                title: 'All Orders',
                                subtitle: 'Classification',
                            }
                        };

                        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                        chart.draw(data, options);
                    }
                </script>


                <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>

            </div>
            <!------- END OF FIRST CHART ------>

            <!------- Second CHART (USERS) ------>
            <div class="row">

                <script type="text/javascript">
                    google.charts.load('current', {
                        'packages': ['corechart']
                    });
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {

                        var data = google.visualization.arrayToDataTable([
                            ['Users', 'Categories'],
                            <?php

                            $element_text = array('Admin', 'Customers', 'Driver');
                            $element_count = array($admin_count, $customer_count, $driver_count);

                            $size_of_array = sizeof($element_count);

                            for ($i = 0; $i < $size_of_array; $i++) {

                                echo "['{$element_text[$i]}'" . "," . "{$element_count[$i]}],";
                            }

                            ?>
                        ]);

                        var options = {
                            title: 'Users Classification'
                        };

                        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                        chart.draw(data, options);
                    }
                </script>

                <div id="piechart" style="width: 'auto'; height: 500px;"></div>

            </div>
            <!------- END OF Second CHART ------>

            <!------- Third CHART (Food items in different categories) ------>
            <div class="row">

                <script type="text/javascript">
                    google.charts.load('current', {
                        'packages': ['bar']
                    });
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                            ['Data', 'Numbers'],

                            <?php

                            $element_text = array('Drinks', 'Starters', 'Dessert', 'Main Dish');
                            $element_count = array($category_count_1, $category_count_2, $category_count_3, $category_count_4);

                            $size_of_array = sizeof($element_count);

                            for ($i = 0; $i < $size_of_array; $i++) {

                                echo "['{$element_text[$i]}'" . "," . "{$element_count[$i]}],";
                            }

                            ?>
                        ]);

                        var options = {
                            chart: {
                                title: 'Food Items in Different Categories',
                                subtitle: 'Classifications',
                            },
                            bars: 'horizontal' // Required for Material Bar Charts.
                        };

                        var chart = new google.charts.Bar(document.getElementById('barchart_material'));

                        chart.draw(data, google.charts.Bar.convertOptions(options));
                    }
                </script>

                <div id="barchart_material" style="width: 'auto'; height: 500px;"></div>

            </div>
            <!------- END OF Third CHART ------>


        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->
</div>

<?php
include "includes/footer.php";
?>