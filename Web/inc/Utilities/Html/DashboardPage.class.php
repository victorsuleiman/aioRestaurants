<?php

    class DashboardPage{

        public static function pageLeftMenu(){
            $leftMenu = ' 
                <!-- Left column -->
                <div class="priori-flex-row" id="page-body">
                    <div class="priori-sidebar">
                        <header class="priori-site-header">
                        <i class="fas fa-money-check"></i>
                        <img src="images/dashboard-icon.png" width="50" height="50">
                       
                        <h1>aioRestaurant</h1>
                        </header>
                        <div class="profile-photo-container">
                        <img src="images/profile-photo.jpg" alt="Profile Photo" class="img-responsive">  
                        <div class="profile-photo-overlay"></div>
                        </div>
                           
                        <div class="mobile-menu-icon">
                            <i class="fa fa-bars"></i>
                        </div>
                        <nav class="priori-left-nav">          
                        <ul>
                            <li><a href="?page=dashboard" class="active"><i class="fa fa-home fa-fw"></i>Dashboard</a></li>
                            <li><a href="?page=charts"><i class="fa fa-bar-chart fa-fw"></i>Charts</a></li>
                            <li><a href="?page=tables&tab=employee"><i class="fa fa-users fa-fw"></i>Tables</a></li>
                            <li><a href="login.php"><i class="fa fa-eject fa-fw"></i>Sign Out</a></li>
                        </ul>    
                        </nav>
                    </div>
                
            ';
            echo $leftMenu;
        }

        public static function divGraphs(){
            echo '
            <div class="row">
                <div id="pie_chart_div" class="priori-chart"></div>
                <div id="bar_chart_div" class="priori-chart"></div>
            </div>
            ';
        }

        public static function barChart($productArray){

            $dataAddRows = "
                    data.addRows([";
            for($i = 0; $i < count($productArray); $i++){
                if($i == count($productArray)-1){
                    $dataAddRows .= "['".$productArray[$i]->getProductName()."',".$productArray[$i]->getQuantity()."]
                    ";
                } else {
                    $dataAddRows .= "['".$productArray[$i]->getProductName()."',".$productArray[$i]->getQuantity()."],
                    ";
                }
            }


            $dataAddRows .= "]);";

            $script = "
            <script>
                /* Google Chart 
                -------------------------------------------------------------------*/
                // Load the Visualization API and the piechart package.
                google.load('visualization', '1.0', {'packages':['corechart']});

                // Set a callback to run when the Google Visualization API is loaded.
                google.setOnLoadCallback(drawChart); 
                
                // Callback that creates and populates a data table,
                // instantiates the pie chart, passes in the data and
                // draws it.
                function drawChart() {

                    // Create the data table.
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'Products');
                    data.addColumn('number', 'Units');";
            $script .= $dataAddRows;
            $script .= "
                    // Set chart options
                    var options = {'title':'Produts bought lately'};

                    var barChart = new google.visualization.BarChart(document.getElementById('bar_chart_div'));
                    barChart.draw(data, options);
                }

                $(document).ready(function(){
                    if($.browser.mozilla) {
                    //refresh page on browser resize
                    // http://www.sitepoint.com/jquery-refresh-page-browser-resize/
                    $(window).bind('resize', function(e)
                    {
                        if (window.RT) clearTimeout(window.RT);
                        window.RT = setTimeout(function()
                        {
                        this.location.reload(false); /* false to get page from cache */
                        }, 200);
                    });      
                    } else {
                    $(window).resize(function(){
                        drawChart();
                    });  
                    }   
                });
                
                </script>
            ";

            echo $script;
        }

        public static function pieChart($productArray){
            $script = '
                <!-- JS -->
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                <script src="js/jquery-1.11.2.min.js"></script>      <!-- jQuery -->
                <script src="js/jquery-migrate-1.2.1.min.js"></script> <!--  jQuery Migrate Plugin -->
                <script src="https://www.google.com/jsapi"></script> <!-- Google Chart -->
                
            ';

            $script .= "
            <script>
                /* Google Chart 
                -------------------------------------------------------------------*/
                // Load the Visualization API and the piechart package.
                google.load('visualization', '1.0', {'packages':['corechart']});

                // Set a callback to run when the Google Visualization API is loaded.
                google.setOnLoadCallback(drawChart); 
                
                // Callback that creates and populates a data table,
                // instantiates the pie chart, passes in the data and
                // draws it.
                function drawChart() {

                    // Create the data table.
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'Products');
                    data.addColumn('number', 'Quantity');
                    data.addRows([";
                for($i = 0; $i < count($productArray); $i++){
                    if($i == count($productArray)-1){
                        $script .= "['".$productArray[$i]->getProductName()."',".$productArray[$i]->getQuantity()."]
                        ";
                    } else {
                        $script .= "['".$productArray[$i]->getProductName()."',".$productArray[$i]->getQuantity()."],
                        ";
                    }
                    
                }
            //$script .= ;
            $script .= "]);
                    // Set chart options
                    var options = {'title':'Last Products bought'};

                    // Instantiate and draw our chart, passing in some options.
                    var pieChart = new google.visualization.PieChart(document.getElementById('pie_chart_div'));
                    pieChart.draw(data, options);
                }

                $(document).ready(function(){
                    if($.browser.mozilla) {
                    //refresh page on browser resize
                    // http://www.sitepoint.com/jquery-refresh-page-browser-resize/
                    $(window).bind('resize', function(e)
                    {
                        if (window.RT) clearTimeout(window.RT);
                        window.RT = setTimeout(function()
                        {
                        this.location.reload(false); /* false to get page from cache */
                        }, 200);
                    });      
                    } else {
                    $(window).resize(function(){
                        drawChart();
                    });  
                    }   
                });
                
                </script>
            ";
            $script .= '<script type="text/javascript" src="js/script.js"></script>';

            echo $script;
        }
        /*
        public static function scriptImport(){
            $script = '
                <!-- JS -->
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                <script src="js/jquery-1.11.2.min.js"></script>      <!-- jQuery -->
                <script src="js/jquery-migrate-1.2.1.min.js"></script> <!--  jQuery Migrate Plugin -->
                <script src="https://www.google.com/jsapi"></script> <!-- Google Chart -->
                
            ';
            echo $script;
        }

        public static function scriptFooter(){
            $script = '<script type="text/javascript" src="js/script.js"></script>';
            echo $script;
        }
        */
    }