<?php

    class FormHtml{


        //Employee
        public static function addEmployee(){
            $modalForm = '
            <div>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                    Add New Entry
                </button>
                <div class="modal priori-editForm" id="myModal">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                
                            <!-- Modal Header -->
                            <div class="modal-header">
                            <h4 class="modal-title">Edit Form</h4>
                            <button type="button" class="close" data-dismiss="modal">
                                ×
                            </button>
                            </div>

                    <!-- Modal body -->
                    <div class="modal-body">';
                    $modalForm .= self::addFormEmployee();
                    $modalForm .= '</div>
                </div>
            </div>
            <!-- Form End -->
            ';
            return $modalForm;
        }

        public static function editEmployee(Employee $employee){

            $modalForm = '
            <div>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal'.$employee->getEmployeeId().'">
                    Edit
                </button>
                <div class="modal priori-editForm" id="myModal'.$employee->getEmployeeId().'">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                
                            <!-- Modal Header -->
                            <div class="modal-header">
                            <h4 class="modal-title">Edit Form</h4>
                            <button type="button" class="close" data-dismiss="modal">
                                ×
                            </button>
                            </div>

                    <!-- Modal body -->
                    <div class="modal-body">';
                    $modalForm .= self::editFormEmployee($employee);
                    $modalForm .= '</div>
                </div>
            </div>
            <!-- Form End -->
            ';
            return $modalForm;
        }

        private static function editFormEmployee(Employee $employee){
            /**** FORM CLEAR BUTTON ****/
            /*
            <button type="button" class="btn btn-warning" onclick="clearFields(this.form)">
                Clear
            </button>
            */

            $form = '
            <form action="'.$_SERVER['PHP_SELF'].'" method="POST" enctype="multipart/form-data" id="employee'.$employee->getEmployeeId().'">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td>
                                First Name:
                            </td>
                            <td>
            <input type="text" class="form-control mb-2 mr-sm-2" placeholder="First Name" value="'.$employee->getFirstName().'" name="firstName">
                            </td>
                            <td>
                                Last Name:
                            </td>
                            <td>
            <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Last Name" value="'.$employee->getLastName().'" name="lastName">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Birth Date:
                            </td>
                            <td>
            <input type="date" class="form-control mb-2 mr-sm-2" value="'.$employee->getBDate().'" name="bDate">
                            </td>
                            <td>
                                Address:
                            </td>
                            <td>
            <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Address" value="'.$employee->getAddress().'" name="address">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                City:
                            </td>
                            <td>
            <input type="text" class="form-control mb-2 mr-sm-2"  placeholder="City" value="'.$employee->getCity().'" name="city">
                            </td>
                            <td>
                                Postal Code:
                            </td>
                            <td>
            <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Postal Code" value="'.$employee->getPostalCode().'" name="postalCode">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Phone:
                            </td>
                            <td>
            <input type="text" class="form-control mb-2 mr-sm-2"  placeholder="XXX-XXX-XXXX" value="'.$employee->getPhone().'" name="phone">
                            </td>
                            <td>
                                Email:
                            </td>
                            <td>
            <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Email" value="'.$employee->getEmail().'" name="email">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Notes:
                            </td>
                            <td>
                                <textarea class="form-control" rows="3" id="comment" name="notes">
                                '.$employee->getNotes().'
                                </textarea>
                            </td>
                            <td>
                                User Category:
                            </td>
                            <td>
                                <select class="form-control" name="userCategory">
                                    <option value="1" selected>Admin</option>
                                    <option value="2">Lite Admin</option>
                                    <option value="3">User</option>
                                    <option value="4">Super User</option>
                                    <option value="5">Financial</option>
                                    <option value="6">Guest</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Username:
                            </td>
                            <td>
            <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Username" value="'.$employee->getUsername().'" name="username">
                            </td>
                            <td>
                                Password:
                            </td>
                            <td>
            <input type="password" class="form-control mb-2 mr-sm-2" placeholder="Password" name="password">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        Close
                    </button>
                    <input type="submit" class="btn btn-success" value="Submit">
                </div>
            </form>
            ';
            return $form;
        }
        
        private static function addFormEmployee(){

            $form = '
            <form action="'.$_SERVER['PHP_SELF'].'" method="POST" enctype="multipart/form-data" id="employee">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td>
                                First Name:
                            </td>
                            <td>
            <input type="text" class="form-control mb-2 mr-sm-2" placeholder="First Name" value="" name="firstName">
                            </td>
                            <td>
                                Last Name:
                            </td>
                            <td>
            <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Last Name" value="" name="lastName">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Birth Date:
                            </td>
                            <td>
            <input type="date" class="form-control mb-2 mr-sm-2" value="" name="bDate">
                            </td>
                            <td>
                                Address:
                            </td>
                            <td>
            <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Address" value="" name="address">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                City:
                            </td>
                            <td>
            <input type="text" class="form-control mb-2 mr-sm-2"  placeholder="City" value="" name="city">
                            </td>
                            <td>
                                Postal Code:
                            </td>
                            <td>
            <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Postal Code" value="" name="postalCode">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Phone:
                            </td>
                            <td>
            <input type="text" class="form-control mb-2 mr-sm-2"  placeholder="XXX-XXX-XXXX" value="" name="phone">
                            </td>
                            <td>
                                Email:
                            </td>
                            <td>
            <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Email" value="" name="email">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Notes:
                            </td>
                            <td>
            <textarea class="form-control" rows="3" id="comment" name="notes"></textarea>
                            </td>
                            <td>
                                User Category:
                            </td>
                            <td>
                                <select class="form-control" name="userCategory">
                                    <option value="1" selected>Admin</option>
                                    <option value="2">Lite Admin</option>
                                    <option value="3">User</option>
                                    <option value="4">Super User</option>
                                    <option value="5">Financial</option>
                                    <option value="6">Guest</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Username:
                            </td>
                            <td>
            <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Username" value="" name="username">
                            </td>
                            <td>
                                Password:
                            </td>
                            <td>
            <input type="password" class="form-control mb-2 mr-sm-2" placeholder="Password" name="password">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        Close
                    </button>
                    <input type="reset" class="btn btn-warning" value="Clear">
                    <input type="submit" class="btn btn-success" value="Submit">
                </div>
            </form>
            ';
            return $form;
        }
        
        
        //Shipper
        public static function addShipper(){
            $modalForm = '
            <div>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                    Add New Entry
                </button>
                <div class="modal priori-editForm" id="myModal">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                
                            <!-- Modal Header -->
                            <div class="modal-header">
                            <h4 class="modal-title">Edit Form</h4>
                            <button type="button" class="close" data-dismiss="modal">
                                ×
                            </button>
                            </div>

                    <!-- Modal body -->
                    <div class="modal-body">';
                    $modalForm .= self::addFormShipper();
                    $modalForm .= '</div>
                </div>
            </div>
            <!-- Form End -->
            ';
            return $modalForm;
        }

        public static function editShipper(Shipper $shipper){
            $modalForm = '
            <div>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal'.$shipper->getShipperId().'">
                    Edit
                </button>
                <div class="modal priori-editForm" id="myModal'.$shipper->getShipperId().'">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                
                            <!-- Modal Header -->
                            <div class="modal-header">
                            <h4 class="modal-title">Edit Form</h4>
                            <button type="button" class="close" data-dismiss="modal">
                                ×
                            </button>
                            </div>

                    <!-- Modal body -->
                    <div class="modal-body">';
                    $modalForm .= self::editFormShipper($shipper);
                    $modalForm .= '</div>
                </div>
            </div>
            <!-- Form End -->
            ';
            return $modalForm;
        }
        
        private static function addFormShipper(){
            $form = '
            <form action="'.$_SERVER['PHP_SELF'].'" method="POST" enctype="multipart/form-data" id="shipper">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td>
                                Shipper:
                            </td>
                            <td>
                                <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Shipper Name" value="" name="shipperName">
                            </td>
                            <td>
                                Contact Person:
                            </td>
                            <td>
                                <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Person Name" value="" name="contactName">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Address:
                            </td>
                            <td>
                                <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Address" value="" name="address">
                            </td>
                            <td>
                                City:
                            </td>
                            <td>
                                <input type="text" class="form-control mb-2 mr-sm-2"  placeholder="City" value="" name="city">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Country:
                            </td>
                            <td>
                                <input type="text" class="form-control mb-2 mr-sm-2"  placeholder="Country" value="" name="country">
                            </td>
                            <td>
                                Price:
                            </td>
                            <td>
                                <input type="text" class="form-control mb-2 mr-sm-2"  placeholder="Price" value="" name="price">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Phone:
                            </td>
                            <td>
            <input type="text" class="form-control mb-2 mr-sm-2"  placeholder="XXX-XXX-XXXX" value="" name="phone">
                            </td>
                            <td>
                                Email:
                            </td>
                            <td>
            <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Email" value="" name="email">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        Close
                    </button>
                    <input type="reset" class="btn btn-warning" value="Clear">
                    <input type="submit" class="btn btn-success" value="Submit">
                </div>
            </form>
            ';
            return $form;
        }

        private static function editFormShipper(Shipper $shipper){
            $form = '
            <form action="'.$_SERVER['PHP_SELF'].'" method="POST" enctype="multipart/form-data" id="shipper'.$shipper->getShipperId().'">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td>
                                Shipper:
                            </td>
                            <td>
                                <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Shipper Name" value="'.$shipper->getShipperName().'" name="shipperName">
                            </td>
                            <td>
                                Contact Person:
                            </td>
                            <td>
                                <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Person Name" value="'.$shipper->getContactName().'" name="contactName">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Address:
                            </td>
                            <td>
                                <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Address" value="'.$shipper->getAddress().'" name="address">
                            </td>
                            <td>
                                City:
                            </td>
                            <td>
                                <input type="text" class="form-control mb-2 mr-sm-2"  placeholder="City" value="'.$shipper->getCity().'" name="city">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Country:
                            </td>
                            <td>
                                <input type="text" class="form-control mb-2 mr-sm-2"  placeholder="Country" value="'.$shipper->getCity().'" name="country">
                            </td>
                            <td>
                                Notes:
                            </td>
                            <td>
                                <input type="text" class="form-control mb-2 mr-sm-2"  placeholder="Price" value="'.$shipper->getPrice().'" name="price">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Phone:
                            </td>
                            <td>
            <input type="text" class="form-control mb-2 mr-sm-2"  placeholder="XXX-XXX-XXXX" value="'.$shipper->getPhone().'" name="phone">
                            </td>
                            <td>
                                Email:
                            </td>
                            <td>
            <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Email" value="'.$shipper->getEmail().'" name="email">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        Close
                    </button>
                    <input type="reset" class="btn btn-warning" value="Clear">
                    <input type="submit" class="btn btn-success" value="Submit">
                </div>
            </form>
            ';
            return $form;
        }
        
    }