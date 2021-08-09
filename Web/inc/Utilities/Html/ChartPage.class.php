<?php

    class ChartPage{

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
                            <li><a href="?page=dashboard"><i class="fa fa-home fa-fw"></i>Dashboard</a></li>
                            <li><a href="?page=charts" class="active"><i class="fa fa-bar-chart fa-fw"></i>Charts</a></li>
                            <li><a href="?page=tables&tab=employee"><i class="fa fa-users fa-fw"></i>Tables</a></li>
                            <li><a href="login.php"><i class="fa fa-eject fa-fw"></i>Sign Out</a></li>
                        </ul>  
                        </nav>
                    </div>
                
            ';
            echo $leftMenu;
        }

        public static function divGraphs(){
            $div = '
            <div class="row">
                <div id="pie_chartPayment_div" class="priori-chart"></div>
                <!--<div id="bar_chart_div" class="priori-chart"></div>-->
                <div id="area_chart_div" class="priori-chart"></div>
                <div id="bar_chartEmployee_div" class="priori-chart"></div>
                <div id="linechart_dish" class="priori-chart"></div>
            </div>
            ';

            echo $div;
        }

        public static function resultNotFound($post){
            $date = explode("#",$post["weekGoalReport"]);
            echo '
            <div class="priori-content-container">
                <div class="priori-flex-row flex-content-row">
                    <div class="col-1">
                        <div class="panel panel-default margin-10">
                            <div class="panel-heading">
                            <h2 class="text-uppercase">'.
                            self::formatDate($date[0]).' - '.self::formatDate($date[1])
                            .'</h2></div>
                            <div class="panel-body">
                            <h2 class="text-uppercase">Result Not Found</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            ';
        }

        public static function pieChartPaymentType(Array $recipt){

            $paymentPerformance = self::parseIntoPaymentPerformance($recipt);

            $script = "
            <script>
                /* Google Chart 
                -------------------------------------------------------------------*/
                // Load the Visualization API and the piechart package.
                google.load('visualization', '1.0', {'packages':['corechart']});

                // Set a callback to run when the Google Visualization API is loaded.
                google.setOnLoadCallback(drawPieChart); 
                
                // Callback that creates and populates a data table,
                // instantiates the pie chart, passes in the data and
                // draws it.
                function drawPieChart() {

                    // Create the data table.
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'Payment Type');
                    data.addColumn('number', 'Quantity');
                    data.addRows([";
                for($i = 0; $i < count($paymentPerformance["paymentType"]); $i++){
                    if($i == count($paymentPerformance["paymentType"])-1){
                        $script .= "['".$paymentPerformance["paymentType"][$i]."',".$paymentPerformance["total"][$i]."]
                        ";
                    } else {
                        $script .= "['".$paymentPerformance["paymentType"][$i]."',".$paymentPerformance["total"][$i]."],
                        ";
                    }
                    
                }
            //$script .= ;
            $script .= "]);
                    // Set chart options
                    var options = {'title':'Weekly Payments Type'};

                    // Instantiate and draw our chart, passing in some options.
                    var pieChart = new google.visualization.PieChart(document.getElementById('pie_chartPayment_div'));
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
                        drawPieChart();
                    });  
                    }   
                });
                
                </script>
            ";

            echo $script;
        }

        public static function barChartProduct($productArray){

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
                google.setOnLoadCallback(drawBarChart); 
                
                // Callback that creates and populates a data table,
                // instantiates the pie chart, passes in the data and
                // draws it.
                function drawBarChart() {

                    // Create the data table.
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'Topping');
                    data.addColumn('number', 'Slices');";
            $script .= $dataAddRows;
            $script .= "
                    // Set chart options
                    var options = {'title':'How Much Pizza I Ate Last Night'};

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
                        drawBarChart();
                    });  
                    }   
                });
                
                </script>
            ";

            echo $script;
        }

        public static function pieChartProduct($productArray){

            $script = "
            <script>
                /* Google Chart 
                -------------------------------------------------------------------*/
                // Load the Visualization API and the piechart package.
                google.load('visualization', '1.0', {'packages':['corechart']});

                // Set a callback to run when the Google Visualization API is loaded.
                google.setOnLoadCallback(drawPieChart); 
                
                // Callback that creates and populates a data table,
                // instantiates the pie chart, passes in the data and
                // draws it.
                function drawPieChart() {

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
                        drawPieChart();
                    });  
                    }   
                });
                
                </script>
            ";

            echo $script;
        }
    
        public static function areaChartGoals(Array $recipt, Array $goals){
            $graphArray = self::parseIntoGraph($recipt, $goals);

            $areaData = "google.visualization.arrayToDataTable([
                ['Date', 'Sales', 'Goals'],
                ";
            for($i = 0; $i < count($graphArray["dates"]); $i++){
                if($i == count($graphArray["dates"])-1){
                    $areaData .= "['".$graphArray["dates"][$i]."',".$graphArray["sales"][$i].",".$graphArray["goals"][$i]."]
                    ";
                } else {
                    $areaData .= "['".$graphArray["dates"][$i]."',".$graphArray["sales"][$i].",".$graphArray["goals"][$i]."],
                    ";
                }
            }
            $areaData .="])";

            $script = "
                <script>
                    /* Google Chart 
                    -------------------------------------------------------------------*/
                    // Load the Visualization API and the piechart package.
                    google.load('visualization', '1.0', {'packages':['corechart']});

                    // Set a callback to run when the Google Visualization API is loaded.
                    google.setOnLoadCallback(drawAreaChart);

                    var areaOptions;
                    var areaChart;

                    function drawAreaChart() {
                        areaData = ".$areaData.";
                        areaOptions = {
                            title: 'Sales Performance',
                            hAxis: {title: 'Sales',  titleTextStyle: {color: '#333'}},
                            vAxis: {minValue: 0}
                        };

                        areaChart = new google.visualization.AreaChart(document.getElementById('area_chart_div'));
                        areaChart.draw(areaData, areaOptions);
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
                            drawAreaChart();
                          });  
                        }   
                      });
                </script>";
                
                echo $script;
        }

        public static function barChartEmployee(Array $recipt){
            $employeeResults = self::parseIntoEmpPerformance($recipt);
            
            $dataAddRows = "
                    data.addRows([";
            for($i = 0; $i < count($employeeResults["server"]); $i++){

                if($i == count($employeeResults["server"])-1){
                    $dataAddRows .= "['".$employeeResults["server"][$i]."',".$employeeResults["total"][$i]."]
                    ";
                } else {
                    $dataAddRows .= "['".$employeeResults["server"][$i]."',".$employeeResults["total"][$i]."],
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
                google.setOnLoadCallback(drawBarChartEmployee); 
                
                // Callback that creates and populates a data table,
                // instantiates the pie chart, passes in the data and
                // draws it.
                function drawBarChartEmployee() {

                    // Create the data table.
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'Employee');
                    data.addColumn('number', 'Sales');";
            $script .= $dataAddRows;
            $script .= "
                    // Set chart options
                    var options = {'title':'Weekly Employee Sales performance ($)'};

                    var barChart = new google.visualization.BarChart(document.getElementById('bar_chartEmployee_div'));
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
                        drawBarChartEmployee();
                    });  
                    }   
                });
                
                </script>
            ";

            echo $script;
        }

        public static function inventoryReport(){
            $fileList = glob("inc/data/*.csv");

            $htmlFileList = '
            <script type="text/javascript">
            function download(d) {
                    if (d == "Select document") return;
                    window.location = d;
            }
            </script>

            <form method="post" action="">
            <div class="priori-content-container">
                <div class="priori-flex-row flex-content-row">
                    <div class="col-1">
                        <div class="panel panel-default margin-10">
                            <div class="panel-heading">
                                <h2 class="text-uppercase">Weekly Reports</h2>
                            </div>
                            <div class="panel-body">
                            <select name="reports" class="form-control" onChange="download(this.value)">
                            <option value="'.$_SERVER["PHP_SELF"].'?page=tables&tab=employee">Select a Date</option>
                            ';
                            if(!empty($fileList)){
                                $htmlFileList .= '';
                                if(count($fileList) < 5){
                                    
                                    for($i = 0; $i < count($fileList); $i++){
                                        //Directory string inc/data/file.php
                                        //$path = array("inc","dat","filename");
                                        $path = explode("/",$fileList[$i]);
                                        //count($path)-1 = The filename, no matter the directory is;
                                        $htmlFileList .= '<option value="'.$fileList[$i].'">'.$path[count($path)-1].'</option>
                                        ';
                                    }    
                                } else {
                                    for($i = count($fileList)-1; $i > count($fileList)-5; $i--){
                                        //Directory string inc/data/file.php
                                        //$path = array("inc","dat","filename");
                                        $path = explode("/",$fileList[$i]);
                                        //count($path)-1 = The filename, no matter the directory is;
                                        $htmlFileList .= '<option value="'.$fileList[$i].'">'.$path[count($path)-1].'</option>
                                        ';
                                    }
                                }
                                $htmlFileList .= '</select>';
                            } else {
                                $htmlFileList .= '<h3>There are no available reports!</h3>';
                            }
                $htmlFileList .= '
                <p>
                        <div class="form-group">
                            <input type="submit" value="Download" class="priori-blue-button">
                        </div>
                </p>
                    </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
            ';
           echo $htmlFileList;
        }

        public static function weekReport(){
            $weeks = self::getYearWeeks();
            
            $html = '
            
            <form method="post" action="'.$_SERVER["PHP_SELF"].'?page=charts">
                <input type="hidden" name="form" value="dateReport">
            <div class="priori-content-container">
                <div class="priori-flex-row flex-content-row">
                    <div class="col-1">
                        <div class="panel panel-default margin-10">
                            <div class="panel-heading">
                                <h2 class="text-uppercase">Weekly Reports</h2>
                            </div>
                            <div class="panel-body">
                                <select name="weekGoalReport" class="form-control">';
                    for($i = 0; $i < count($weeks); $i++){
                        $weekNum = $i+1;
                        $html .= '
                        <option value="'.$weeks[$i]["start_date"].'#'.$weeks[$i]["end_date"].'">
                        Week '.$weekNum.':   '.self::formatDate($weeks[$i]["start_date"]).' - '.self::formatDate($weeks[$i]["end_date"])
                        .'</option>';
                    }
            $html .= '</select>
            <p>
                        <div class="form-group">
                            <input type="submit" value="See Week Report" class="priori-blue-button">
                        </div>
                </p>
                    </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>';
            echo $html;
            
        }

        private static function getYearWeeks(){
            
            $year = date("Y");
            $yearWeeks = idate('W', mktime(0, 0, 0, 12, 28, $year));
            
            $dates = [];
    
            for($i = 1; $i <= $yearWeeks; $i++){
                $dates[] = self::getStartAndEndDate($i,$year);
            }
            return $dates;
        }

        private static function getStartAndEndDate($week, $year) {

            $dateTime = new DateTime();
            $dateTime->setISODate($year, $week);
            
            $result['start_date'] = $dateTime->format('Y-m-d');
            $dateTime->modify('+6 days');
            $result['end_date'] = $dateTime->format('Y-m-d');

            return $result;
        }

        private static function parseIntoGraph(Array $recipt, Array $goals){
            $doubleGraph = [];

            $graphGoal = [];
            $dateGoal = [];
            $reciptGoal = [];
            
            for($i = 0; $i < count($goals); $i++){
                $graphGoal[] = $goals[$i]->goal;
                $dateGoal[] = $goals[$i]->date;
            }

            $j = 0;
            for($i = 0; $i < count($graphGoal); $i++){
                $sum = 0;
                
                while($recipt[$j]->getDate() == $dateGoal[$i]){
                    $sum += $recipt[$j]->getTotal();
                    $j++;
                }
                $reciptGoal[] = $sum;
            }

            $doubleGraph = [
                "dates" => $dateGoal,
                "sales" => $reciptGoal,
                "goals" => $graphGoal
            ];
            
            return $doubleGraph;
        }

        private static function formatDate(string $dateUnformat){
            $date = explode("-",$dateUnformat);

            return $date[1]."/".$date[2]."/".$date[0];
        }

        private static function parseIntoEmpPerformance(Array $recipt){
            $serverArray = [];
            $serverTotal = [];
            $serverGraph = [];

            for($i = 0; $i < count($recipt); $i++){
                $serverArray[] = $recipt[$i]->getServer();
            }
            $serverArray = array_values(array_unique($serverArray));

            for($i = 0; $i < count($serverArray); $i++){

                $sum = 0;
                for($j = 0; $j < count($recipt); $j++){

                    if($recipt[$j]->getServer() == $serverArray[$i]){
                        $sum += $recipt[$j]->getTotal();
                    }
                    
                }
                $serverTotal[] = $sum;           
            }
            
            
            $serverGraph = [
                "server" => $serverArray,
                "total" => $serverTotal
            ];
            
            return $serverGraph;
        }

        private static function parseIntoPaymentPerformance(Array $recipt){
            $paymentType = ["cash","credit","debit"];
            $paymentAmount = [];

            for($i = 0; $i < count($paymentType); $i++){
                $sum = 0;
                for($j = 0; $j < count($recipt); $j++){
                    if($recipt[$j]->getPaymentType() == $paymentType[$i]){
                        $sum += $recipt[$j]->getTotal();
                    }
                }
                $paymentAmount[] = $sum;
            }

            $paymentPerformance = [
                "paymentType" => $paymentType,
                "total" => $paymentAmount
            ];

            return $paymentPerformance;
        }

        private static function parseIntoDishesSold(Array $recipt){
            $dish = [];
            $weekDates = [];

            for($i = 0; $i < count($recipt); $i++){
                $weekDates[] = $recipt[$i]->getDate();
            }
            $weekDates = array_values(array_unique($weekDates));

            $j = 0;
            for($i = 0; $i < count($weekDates); $i++){                
                $dishesName = [];

                for($j = 0; $j < count($recipt); $j++){
                    if($recipt[$j]->getDate() == $weekDates[$i]){

                        for($k = 0; $k < count($recipt[$j]->getDishes()); $k++){
                            if(array_key_exists(
                                $recipt[$j]->getDishes()[$k]->getDishName(),
                                $dishesName
                            )){
                                $dishesName[
                                    $recipt[$j]->getDishes()[$k]->getDishName()
                                ] += $recipt[$j]->getDishes()[$k]->getQuantity();
                            } else {
                                $dishesName[
                                    $recipt[$j]->getDishes()[$k]->getDishName()
                                ] = $recipt[$j]->getDishes()[$k]->getQuantity();
                            }
                        }
                    }
                }
                
                $dish[$weekDates[$i]] = $dishesName;
                
            }
            
            return $dish;
        }
        
    }