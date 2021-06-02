<?php
    
    class TableHtml{

        public static function employeeTableContent(Array $employeeArray){
            $employeeTable = '
            <div class="panel panel-default templatemo-content-widget white-bg no-padding templatemo-overflow-hidden">
                <i class="fa fa-times"></i>
                <div class="panel-heading templatemo-position-relative"><h2 class="text-uppercase">User Table</h2></div>
                <div class="table-responsive">
                  <table class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <td>#Id</td>
                        <td>Employee Name</td>
                        <td>User Category</td>
                        <td>Username</td>
                      </tr>
                    </thead>
                    <tbody>';
                    for($i = 0; $i < count($employeeArray); $i++){
                        $employeeTable .= '
                        <tr>
                            <td>'.$employeeArray[$i]->employeeId.'</td>
                            <td>'.$employeeArray[$i]->firstName." ".$employeeArray[$i]->lastName.'</td>
                            <td>'.$employeeArray[$i]->userCategory.'</td>
                            <td>'.$employeeArray[$i]->username.'</td>
                        </tr> 
                        ';
                    }       
            $employeeTable .= '</tbody>
                  </table>    
                </div>                          
              </div>
            ';
            return $employeeTable;
        }
    }