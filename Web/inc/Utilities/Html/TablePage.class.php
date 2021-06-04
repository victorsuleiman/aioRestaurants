<?php
    require_once("inc/Utilities/Html/FormHtml.class.php");
    
  class TablePage{

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
                  <form class="priori-search-form" role="search">
                  <div class="input-group">
                      <button type="submit" class="fa fa-search"></button>
                      <input type="text" class="form-control" placeholder="Search" name="srch-term" id="srch-term">           
                  </div>
                  </form>
                  <div class="mobile-menu-icon">
                      <i class="fa fa-bars"></i>
                  </div>
                  <nav class="priori-left-nav">          
                  <ul>
                      <li><a href="?page=dashboard"><i class="fa fa-home fa-fw"></i>Dashboard</a></li>
                      <li><a href="?page=charts"><i class="fa fa-bar-chart fa-fw"></i>Charts</a></li>
                      <li><a href="data-visualization.html"><i class="fa fa-database fa-fw"></i>Data Visualization</a></li>
                      <!--<li><a href="maps.html"><i class="fa fa-map-marker fa-fw"></i>Maps</a></li>-->
                      <li><a href="?page=tables" class="active"><i class="fa fa-users fa-fw"></i>Tables</a></li>
                      <li><a href="preferences.html"><i class="fa fa-sliders fa-fw"></i>Preferences</a></li>
                      <li><a href="login.html"><i class="fa fa-eject fa-fw"></i>Sign Out</a></li>
                  </ul>  
                  </nav>
              </div>
          
      ';
      echo $leftMenu;
  }

    public static function employeeTableContent(Array $employeeArray){
      $employeeTable = '
      <div class="row">
      <div class="panel panel-default priori-content-widget white-bg no-padding priori-overflow-hidden">
          <div class="panel-heading priori-position-relative">
            <h2 class="text-uppercase">Employee Table</h2>
          </div>
          <div class="table-responsive">
            <table class="table table-striped table-bordered priori-user-table">
              <thead>
                <tr>
                  <td>
                    <a href="#" class="white-text priori-sort-by">
                      #Id <span class="caret"></span>
                    </a>
                  </td>
                  <td>
                    <a href="#" class="white-text priori-sort-by">
                      Employee<span class="caret"></span>
                    </a>
                  </td>
                  <td>
                    <a href="#" class="white-text priori-sort-by">
                      Category <span class="caret"></span>
                    </a>
                  </td>
                  <td>
                    <a href="" class="white-text priori-sort-by">
                      Username <span class="caret"></span>
                    </a>
                  </td>
                  <td>
                    Edit Data
                  </td>
                </tr>
              </thead>
              <tbody>';
              for($i = 0; $i < count($employeeArray); $i++){
                $employeeTable .= '
                <tr>
                  <td>'.$employeeArray[$i]->getEmployeeId().'</td>
                  <td>'.$employeeArray[$i]->getFirstName()." ".$employeeArray[$i]->getLastName().'</td>
                  <td>'.$employeeArray[$i]->getUserCategory().'</td>
                  <td>'.$employeeArray[$i]->getUsername().'</td>
                  <td>'.
                    FormHtml::editEmployee($employeeArray[$i])
                  .'</td>
                </tr> 
                ';
              }      
        $employeeTable .= '</tbody>
              </table>    
            </div>                          
          </div>
        </div>
      ';
      echo $employeeTable;
    }
  
    public static function shipperTableContent(Array $shipperArray){
      $shipperTable = '
      <div class="row">
      <div class="panel panel-default priori-content-widget white-bg no-padding priori-overflow-hidden">
          <div class="panel-heading priori-position-relative">
            <h2 class="text-uppercase">Shipper Table</h2>
          </div>
          <div class="table-responsive">
            <table class="table table-striped table-bordered priori-user-table">
              <thead>
                <tr>
                  <td>#Id</td>
                  <td>Shipper</td>
                  <td>Contact Name</td>
                  <td>Email</td>
                </tr>
              </thead>
              <tbody>';
              for($i = 0; $i < count($shipperArray); $i++){
                $shipperTable .= '
                <tr>
                  <td>'.$shipperArray[$i]->getShipperId().'</td>
                  <td>'.$shipperArray[$i]->getShipperName().'</td>
                  <td>'.$shipperArray[$i]->getContactName().'</td>
                  <td>'.$shipperArray[$i]->getEmail().'</td>
                </tr> 
                ';
              }       
        $shipperTable .= '</tbody>
              </table>    
            </div>                          
          </div>
        </div>
      ';
      echo $shipperTable;
    }

    public static function supplierTableContent(Array $supplierArray){
      $supplierTable = '
      <div class="row">
      <div class="panel panel-default priori-content-widget white-bg no-padding priori-overflow-hidden">
          <div class="panel-heading priori-position-relative">
            <h2 class="text-uppercase">Supplier Table</h2>
          </div>
          <div class="table-responsive">
            <table class="table table-striped table-bordered priori-user-table">
              <thead>
                <tr>
                  <td>#Id</td>
                  <td>Supplier</td>
                  <td>Contact</td>
                  <td>Email</td>
                  <td></td>
                </tr>
              </thead>
              <tbody>';

              for($i = 0; $i < count($supplierArray); $i++){
                $supplierTable .= '
                <tr>
                  <td>'.$supplierArray[$i]->getSupplierId().'</td>
                  <td>'.$supplierArray[$i]->getSupplierName().'</td>
                  <td>'.$supplierArray[$i]->getContactName().'</td>
                  <td>'.$supplierArray[$i]->getEmail().'</td>
                  <td>';

                  $supplierTable .= '
                  <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Products
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';

                    for($j = 0; $j < count($supplierArray[$i]->getProducts()); $j++){
                      if( $j == count($supplierArray[$i]->getProducts()) ){
                        $supplierTable .= '
                        <a class="dropdown-item products" href="#">
                        '.$supplierArray[$i]->getProducts()[$j]->getProductName().'
                        </a>';
                      } else {
                        $supplierTable .= '
                        <a class="dropdown-item products" href="#">
                        '.$supplierArray[$i]->getProducts()[$j]->getProductName().'
                        </a><br>';
                      }
                      

                    }

                  $supplierTable .= '
                    </div>
                  </div>
                  ';

                    $supplierTable .= '
                  </td>
                </tr> 
                ';
              }       
        $supplierTable .= '</tbody>
              </table>    
            </div>                          
          </div>
        </div>';
      echo $supplierTable;
    }

    public static function orderTableContent(Array $orderArray){

      $orderTable = '
      <div class="row">
      <div class="panel panel-default priori-content-widget white-bg no-padding priori-overflow-hidden">
          <div class="panel-heading priori-position-relative">
            <h2 class="text-uppercase">ORder Table</h2>
          </div>
          <div class="table-responsive">
            <table class="table table-striped table-bordered priori-user-table">
              <thead>
                <tr>
                  <td>#Id</td>
                  <td>Order Date</td>
                  <td>Delivery Date</td>
                  <td>Employee</td>
                  <td>Products</td>
                  <td></td>
                </tr>
              </thead>
              <tbody>';

              for($i = 0; $i < count($orderArray); $i++){
                $orderTable .= '
                <tr>
                  <td>'.$orderArray[$i]->getOrderId().'</td>
                  <td>'.$orderArray[$i]->getOrderDate().'</td>
                  <td>'.$orderArray[$i]->getEstimateDeliveryDate().'</td>
                  <td>'.$orderArray[$i]->getEmployeeId().'</td>
                  <td>';

                  $orderTable .= '
                  <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Products
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';

                    for($j = 0; $j < count($orderArray[$i]->getProducts()); $j++){
                      if( $j == count($orderArray[$i]->getProducts()) ){
                        $orderTable .= '
                        <a class="dropdown-item products" href="#">
                        '.$orderArray[$i]->getProducts()[$j]->getProductName().'
                        </a>';
                      } else {
                        $orderTable .= '
                        <a class="dropdown-item products" href="#">
                        '.$orderArray[$i]->getProducts()[$j]->getProductName().'
                        </a><br>';
                      }
                      

                    }

                  $orderTable .= '
                    </div>
                  </div>
                  ';

                    $orderTable .= '
                  </td>
                  <td>
                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                      Edit
                    </a>
                  </td>
                </tr> 
                ';
              }       
        $orderTable .= '</tbody>
              </table>    
            </div>                          
          </div>
        </div>';

        echo $orderTable;
    }
    
  }

  


  /*
  <div class="table-responsive">
                <h4 class="margin-bottom-15">New Users Table</h4>
                <table class="table table-striped table-hover table-bordered">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Username</th>
                      <th>Email</th>
                      <th>Edit</th>
                      <th>Action</th>
                      <th>Delete</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>John</td>
                      <td>Smith</td>
                      <td>@js</td>
                      <td>a@company.com</td>
                      <td><a href="#" class="btn btn-default">Edit</a></td>                    
                      <td>
                        <!-- Split button -->
                        <div class="btn-group">
                          <button type="button" class="btn btn-info">Action</button>
                          <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Bootstrap</a></li>
                            <li><a href="#">Font Awesome</a></li>
                            <li><a href="#">jQuery</a></li>
                          </ul>
                        </div>
                      </td>
                      <td><a href="#" class="btn btn-link">Delete</a></td>
                    </tr>
                    <tr class="success">
                      <td>2</td>
                      <td>Bill</td>
                      <td>Digital</td>
                      <td>@bd</td>
                      <td>bd@company.com</td>
                      <td><a href="#" class="btn btn-default">Edit</a></td>
                      <td>
                        <!-- Split button -->
                        <div class="btn-group">
                          <button type="button" class="btn btn-info">Action</button>
                          <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Bootstrap</a></li>
                            <li><a href="#">Font Awesome</a></li>
                            <li><a href="#">jQuery</a></li>
                          </ul>
                        </div>
                      </td>
                      <td><a href="#" class="btn btn-link">Delete</a></td>
                    </tr>
                    <tr>
                      <td>3</td>
                      <td>Marry</td>
                      <td>James</td>
                      <td>@mj</td>
                      <td>mj@company.com</td>
                      <td><a href="#" class="btn btn-default">Edit</a></td>
                      <td>
                        <!-- Split button -->
                        <div class="btn-group">
                          <button type="button" class="btn btn-info">Action</button>
                          <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Bootstrap</a></li>
                            <li><a href="#">Font Awesome</a></li>
                            <li><a href="#">jQuery</a></li>
                          </ul>
                        </div>
                      </td>
                      <td><a href="#" class="btn btn-link">Delete</a></td>
                    </tr>
                    <tr>
                      <td>4</td>
                      <td>Carry</td>
                      <td>Land</td>
                      <td>@cl</td>
                      <td>cl@company.com</td>
                      <td><a href="#" class="btn btn-default">Edit</a></td>
                      <td>
                        <!-- Split button -->
                        <div class="btn-group">
                          <button type="button" class="btn btn-info">Action</button>
                          <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Bootstrap</a></li>
                            <li><a href="#">Font Awesome</a></li>
                            <li><a href="#">jQuery</a></li>
                          </ul>
                        </div>
                      </td>
                      <td><a href="#" class="btn btn-link">Delete</a></td>
                    </tr>
                    <tr class="success">
                      <td>5</td>
                      <td>New</td>
                      <td>Caroline</td>
                      <td>@nc</td>
                      <td>nc@company.com</td>
                      <td><a href="#" class="btn btn-default">Edit</a></td>
                      <td>
                        <!-- Split button -->
                        <div class="btn-group">
                          <button type="button" class="btn btn-info">Action</button>
                          <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Bootstrap</a></li>
                            <li><a href="#">Font Awesome</a></li>
                            <li><a href="#">jQuery</a></li>
                          </ul>
                        </div>
                      </td>
                      <td><a href="#" class="btn btn-link">Delete</a></td>
                    </tr>
                    <tr class="danger">
                      <td>6</td>
                      <td>Martin</td>
                      <td>East</td>
                      <td>@me</td>
                      <td>me@company.com</td>
                      <td><a href="#" class="btn btn-default">Edit</a></td>
                      <td>
                        <!-- Split button -->
                        <div class="btn-group">
                          <button type="button" class="btn btn-info">Action</button>
                          <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Bootstrap</a></li>
                            <li><a href="#">Font Awesome</a></li>
                            <li><a href="#">jQuery</a></li>
                          </ul>
                        </div>
                      </td>
                      <td><a href="#" class="btn btn-link">Delete</a></td>
                    </tr>                    
                  </tbody>
                </table>
              </div>
  */