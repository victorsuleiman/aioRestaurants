<?php

    class Page{
        
        public static function pageHeader(){
            if( date("H") == "02") {

                FileAgent::createFile(
                    RestAPI::getData("productInventory",0)
                );
            }
            $header = '
            <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="utf-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1">  
                    <title>aioRestaurant Dashboard - Home</title>
                    <meta name="description" content="">
                    <meta name="aioBusiness" content="priori">
                    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,700" rel="stylesheet" type="text/css">
                    <link href="css/font-awesome.min.css" rel="stylesheet">
                    <link href="css/bootstrap.min.css" rel="stylesheet">
                    <link href="css/style.css" rel="stylesheet">
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
                    
                    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
                    <!-- WARNING: Respond.js doesnt work if you view the page via file:// -->
                    <!--[if lt IE 9]>
                    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
                    <![endif]-->

                    <!-- JS -->
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
                    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                    <script src="js/jquery-1.11.2.min.js"></script>      <!-- jQuery -->
                    <script src="js/jquery-migrate-1.2.1.min.js"></script> <!--  jQuery Migrate Plugin -->
                    <script src="https://www.google.com/jsapi"></script> <!-- Google Chart -->
                
                    <script type="text/javascript" src="js/script.js"></script>
                </head>
                <body onload="startTime()">
                <div id="clock"></div>
            ';

            echo $header;
        }

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

                        <!-- Search box -->
                        <!-- 
                        <form class="priori-search-form" role="search">
                        <div class="input-group">
                            <button type="submit" class="fa fa-search"></button>
                            <input type="text" class="form-control" placeholder="Search" name="srch-term" id="srch-term">           
                        </div>
                        </form>
                        -->

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

        private static function pageTopRightContent(){
            $topRightContent = '
            <!-- This DIV is closed at the end of the right content -->
            <div class="priori-content col-1 light-gray-bg">
                <div class="priori-top-nav-container">
                <div class="row">
                    <nav class="priori-top-nav col-lg-12 col-md-12">
                    <ul class="text-uppercase">';

                        if(isset($_GET["page"])){
                            switch($_GET["page"]){
                                case "dashboard":
                                    $topRightContent .= '<li>Dashboard</li>';
                                break;
    
                                case "tables":
                                    $topRightContent .= '<li>Tables</li>';
                                break;
    
                                case "charts":
                                    $topRightContent .= '<li>Charts</li>';
                                break;
    
                                default:
                                    $topRightContent .= '<li>Dashboard</li>';
                                break;
                            }
                        } else {
                            $topRightContent .= '<li>Login</li>';
                        }
            $topRightContent .= '</ul>
                    </nav> 
                </div>
                </div>
            ';
            echo $topRightContent;
        }

        
        //This function will add any HTML content
        public static function pageContentTop(){
            //Attach the top title from the page content
            echo self::pageTopRightContent();

            //Start the main content
            $mainContent = '<div class="priori-content-container">
            
            ';
            echo $mainContent;
            
        }

        public static function pageContentBottom(){
            //Ends the main content
            $mainContent = '</div>';

            //The div from the whole right content is closed;
            $mainContent .= "</div><!-- Here the div right content is closed -->";
            echo $mainContent;
        }

        //#673AB7
        //#512DA8
        private static function pageJavaScript(){
            /*$script = '
                <!-- JS -->
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                <script src="js/jquery-1.11.2.min.js"></script>      <!-- jQuery -->
                <script src="js/jquery-migrate-1.2.1.min.js"></script> <!--  jQuery Migrate Plugin -->
                <script src="https://www.google.com/jsapi"></script> <!-- Google Chart -->
                
            ';*/
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
                    data.addColumn('string', 'Topping');
                    data.addColumn('number', 'Slices');
                    data.addRows([
                        ['Orange - Blood',99],
                        ['Pasta - Agnolotti - Butternut',265],
                        ['Oil - Cooking Spray',101],
                        ['Crab Meat Claw Pasteurise',200],
                        ['Wine - Cave Springs Dry Riesling',83],
                        ['Prunes - Pitted',36],
                        ['Cookie Choc',28],
                        ['Vinegar - Cider',145]
                    ]);

                    // Set chart options
                    var options = {'title':'How Much Pizza I Ate Last Night'};

                    // Instantiate and draw our chart, passing in some options.
                    var pieChart = new google.visualization.PieChart(document.getElementById('pie_chart_div'));
                    pieChart.draw(data, options);

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
            //$script .= '<script type="text/javascript" src="js/script.js"></script>';
            
            echo $script;
        }

        public static function pageFooter(){
            $footer = self::pageJavaScript();
            $footer .= '
            </body>
            </html>
            ';

            echo $footer;
        }

        public static function toastAdded(){
            $toast = '
            <div class="alert alert-success" role="alert" id="addAlert">
                Data Added successfully!
                <button type="button" class="close" data-dismiss="alert">
                    ×
                </button>
            </div>
            ';
            echo $toast;
        }

        public static function toastUpdate(){
            $toast = '
            <div class="alert alert-success" role="alert" id="addAlert">
                Data updated successfully!
                <button type="button" class="close" data-dismiss="alert">
                    ×
                </button>
            </div>
            ';
            echo $toast;
        }

        public static function toastDeleted(){
            $toast = '
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body">
                    Hello, world! This is a toast message.
                    <div class="mt-2 pt-2 border-top">
                        <button type="button" class="btn btn-success btn-sm" data-bs-dismiss="toast">
                            Data deleted successfully!
                        </button>
                    </div>
                </div>
            </div>
            ';
            echo $toast;
        }

        public static function loginForm(){
            
            $loginForm = '
            <div class="priori-content-container">
                <div class="priori-flex-row flex-content-row">
                    <div class="col-1">
                        <div class="panel panel-default margin-10">
                            <div class="panel-heading">
                                <h2 class="text-uppercase">Login Form</h2>
                            </div>
                            <div class="panel-body">
                                <form method="post" action="'.$_SERVER["PHP_SELF"].'" class="priori-login-form">
                                    <div class="form-group">
                                        <label for="inputEmail">Username: </label>
                                        <input type="text" name="usernameL" class="form-control" id="inputEmail" placeholder="Username">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail">Password: </label>
                                        <input type="password" name="password" id="inputEmail" class="form-control" placeholder="Password">
                                        </div>
                                    <div class="form-group">
                                        <input type="submit" value="Login" class="priori-blue-button" data-target="#messageModal">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            ';

            echo $loginForm;
        }

        public static function leftMenuGuest(){
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
                        <!-- Search box -->
                        <!-- 
                        <form class="priori-search-form" role="search">
                        <div class="input-group">
                            <button type="submit" class="fa fa-search"></button>
                            <input type="text" class="form-control" placeholder="Search" name="srch-term" id="srch-term">           
                        </div>
                        </form>
                        -->
                        <div class="mobile-menu-icon">
                            <i class="fa fa-bars"></i>
                        </div>
                        <nav class="priori-left-nav">          
                        <ul>
                            <li><a href="#"><i class="fa fa-home fa-fw"></i>Dashboard</a></li>
                            <li><a href="#"><i class="fa fa-bar-chart fa-fw"></i>Charts</a></li>
                            <li><a href="#"><i class="fa fa-users fa-fw"></i>Tables</a></li>
                            <li><a href="login.php" class="active"><i class="fa fa-eject fa-fw"></i>Login</a></li>
                        </ul>  
                        </nav>
                    </div>
                
            ';
            echo $leftMenu;
        }

        public static function modalMessage(string $message){
            $modal = '
            <!-- Modal -->
                <div class="modal hide fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"><p>'.
                        $message
                    .'</p></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    </div>
                    </div>
                </div>
                </div>
            ';

            $modal .= "
            <script>
                $(window).submit(function () {
                    $('#messageModal').modal('show');
                });
            </script>
            ";

            $modal = '
            <script>
                alert("'.$message.'");
            </script>
            ';

            echo self::pageHeader().$modal;
        }
    }