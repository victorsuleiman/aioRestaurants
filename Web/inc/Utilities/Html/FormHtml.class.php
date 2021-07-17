<?php

    class FormHtml{
        //private static $supplier;

        //Employee
        public static function addEmployee(){
            $modalForm = '
            <div>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalEmployee">
                    Add New Entry
                </button>
                <div class="modal priori-editForm" id="myModalEmployee">
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
                <button type="button" class="priori-edit-btn" data-toggle="modal" data-target="#myModal'.$employee->getEmployeeId().'">
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

            $form = '
            <form action="'.$_SERVER['PHP_SELF'].'?page=tables" method="POST" enctype="multipart/form-data" id="employee'.$employee->getEmployeeId().'">
                <input type="hidden" name="_id" value='.$employee->getId().'>
                <input type="hidden" name="employeeId" value='.$employee->getEmployeeId().'>
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
                    <input type="submit" class="btn btn-success" value="Submit" id="edit">
                    <input type="hidden" name="form" value="editEmployee">
                </div>
            </form>
            ';
            return $form;
        }
        
        private static function addFormEmployee(){

            $form = '
            <form action="'.$_SERVER['PHP_SELF'].'?page=tables" method="POST" enctype="multipart/form-data" id="employee">
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
                    <input type="submit" class="btn btn-success" value="Submit" id="add">
                    <input type="hidden" name="form" value="addEmployee">
                </div>
            </form>
            ';
            return $form;
        }
        
        
        //Shipper
        public static function addShipper(){
            $modalForm = '
            <div>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalShipper">
                    Add New Entry
                </button>
                <div class="modal priori-editForm" id="myModalShipper">
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
                <button type="button" class="priori-edit-btn" data-toggle="modal" data-target="#myModal'.$shipper->getShipperId().'">
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
            <form action="'.$_SERVER['PHP_SELF'].'?page=tables" method="POST" enctype="multipart/form-data" id="shipper">
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
                    <input type="submit" class="btn btn-success" value="Submit" id="add">
                    <input type="hidden" name="form" value="addShipper">
                </div>
            </form>
            ';
            return $form;
        }

        private static function editFormShipper(Shipper $shipper){
            $form = '
            <form action="'.$_SERVER['PHP_SELF'].'?page=tables" method="POST" enctype="multipart/form-data" id="shipper'.$shipper->getShipperId().'">
                <input type="hidden" name="_id" value='.$shipper->getId().'>
                <input type="hidden" name="shipperId" value='.$shipper->getShipperId().'>
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
                    <input type="submit" class="btn btn-success" value="Submit" id="edit">
                    <input type="hidden" name="form" value="editShipper">
                </div>
            </form>
            ';
            return $form;
        }

        //ProductInventory
        //private static $supplier;
        public static function addProductInventory(){
            $modalForm = '
            <div>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalProductIn">
                    Add New Entry
                </button>
                <div class="modal priori-editForm" id="myModalProductIn">
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
                    $modalForm .= self::addFormProductInventory();
                    $modalForm .= '</div>
                </div>
            </div>
            <!-- Form End -->
            ';
            return $modalForm;
        }

        private static function addFormProductInventory(){
            $form = '
            <form action="'.$_SERVER['PHP_SELF'].'?page=tables" method="POST" enctype="multipart/form-data" id="productIn">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td>
                                Order ID#: 
                            </td>
                            <td>
                                <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Order #Number" value="" name="orderId">
                            </td>
                            <td>
                                Supplier ID#: 
                            </td>
                            <td>
                                <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Supplier #Number" value="" name="supplierId">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Product Descr.:
                            </td>
                            <td>
                                <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Product Name" value="" name="productName">
                            </td>
                            <td>
                                Measurement Unit:
                            </td>
                            <td>
                                <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Measurement Unit" value="" name="unit">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Quantity:
                            </td>
                            <td>
                                <input type="text" class="form-control mb-2 mr-sm-2"  placeholder="Quantity" value="" name="qty">
                            </td>
                            <td>
                                Price per Unity:
                            </td>
                            <td>
                                <input type="text" class="form-control mb-2 mr-sm-2"  placeholder="Price per Unity" value="" name="price">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Product Category:
                            </td>
                            <td>
                                <select name="category" class="form-control mb-2 mr-sm-2">
                                    <option value="Beverages">Beverages</option>
                                    <option value="Condiments">Condiments </option>
                                    <option value="Confections">Confections</option>
                                    <option value="Dairy Products">Dairy Products</option>
                                    <option value="Grains/Cereals">Grains/Cereals</option>
                                    <option value="Meat/Poultry">Meat/Poultry</option>
                                    <option value="Produce">Produce</option>
                                    <option value="Seafood">Seafood</option>
                                </select>
                            </td>
                            <td>
                                Entry Date:
                            </td>
                            <td>
                                <input type="date" class="form-control mb-2 mr-sm-2" value="" name="entryDate">
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
                    <input type="submit" class="btn btn-success" value="Submit" id="add">
                    <input type="hidden" name="form" value="addProductInventory">
                    
                </div>
            </form>
            ';
            return $form;
        }

        public static function editProductInventory(ProductInventory $product){
            $modalForm = '
            <div>
                <button type="button" class="priori-edit-btn" data-toggle="modal" data-target="#myModal'.$product->getProductId().'">
                    Edit
                </button>
                <div class="modal priori-editForm" id="myModal'.$product->getProductId().'">
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
                    $modalForm .= self::editFormProductInventory($product);
                    $modalForm .= '</div>
                </div>
            </div>
            <!-- Form End -->
            ';
            return $modalForm;
        }

        private static function editFormProductInventory(ProductInventory $product){
            $form = '
            <form action="'.$_SERVER['PHP_SELF'].'?page=tables" method="POST" enctype="multipart/form-data" id="product'.$product->getProductId().'">
                <input type="hidden" name="_id" value='.$product->getId().'>
                <input type="hidden" name="productId" value='.$product->getProductId().'>
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td>
                                Product:
                            </td>
                            <td>
                                <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Product" value="'.$product->getProductName().'" name="productName">
                            </td>
                            <td>
                                Unit:
                            </td>
                            <td>
                                <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Unit" value="'.$product->getUnit().'" name="unit">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Price:
                            </td>
                            <td>
                                <input type="text" class="form-control mb-2 mr-sm-2" placeholder="$Price" value="'.$product->getPrice().'" name="price">
                            </td>
                            <td>
                                Product Category:
                            </td>
                            <td>
                                <select name="category">
                                    <option value="Beverages">Beverages</option>
                                    <option value="Condiments">Condiments </option>
                                    <option value="Confections">Confections</option>
                                    <option value="Dairy Products">Dairy Products</option>
                                    <option value="Grains/Cereals">Grains/Cereals</option>
                                    <option value="Meat/Poultry">Meat/Poultry</option>
                                    <option value="Produce">Produce</option>
                                    <option value="Seafood">Seafood</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Entry Date:
                            </td>
                            <td>
                                <input type="date" class="form-control mb-2 mr-sm-2"  placeholder="Entry Date" value="'.$product->getEntryDate().'" name="entryDate">
                            </td>
                            <td>
                                Withdrawal Date:
                            </td>
                            <td>
                                <input type="date" class="form-control mb-2 mr-sm-2"  placeholder="Out Date" value="'.$product->getOutDate().'" name="outDate">
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
                    <input type="submit" class="btn btn-success" value="Submit" id="edit">
                    <input type="hidden" name="form" value="editProductInventory">
                </div>
            </form>
            ';
            return $form;
        }

        //Order
        public static function editOrder(Order $order){
            $modalForm = '
            <div>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal'.$order->getOrderId().'">
                    Edit
                </button>
                <div class="modal priori-editForm" id="myModal'.$order->getOrderId().'">
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
                    //$modalForm .= self::editFormOrder($order);
                    $modalForm .= '</div>
                </div>
            </div>
            <!-- Form End -->
            ';
            return $modalForm;
        }

        public static function addOrder(){
            $modalForm = '
            <div>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalOrder">
                    Add New Entry
                </button>
                <div class="modal priori-editForm" id="myModalOrder">
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
                    //$modalForm .= self::addFormOrder();
                    $modalForm .= '</div>
                </div>
            </div>
            <!-- Form End -->
            ';
            return $modalForm;
        }

        
        private static function addFormOrder(){
            $form = '
            <form action="'.$_SERVER['PHP_SELF'].'?page=tables&tab=order" method="POST" enctype="multipart/form-data" id="productIn">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td>
                                Order ID#: 
                            </td>
                            <td>
                                <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Order #Number" value="" name="orderId">
                            </td>
                            <td>
                                Supplier ID#: 
                            </td>
                            <td>
                                <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Supplier #Number" value="" name="supplierId">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Product Descr.:
                            </td>
                            <td>
                                <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Product Name" value="" name="productName">
                            </td>
                            <td>
                                Measurement Unit:
                            </td>
                            <td>
                                <input type="text" class="form-control mb-2 mr-sm-2" placeholder="Measurement Unit" value="" name="unit">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Quantity:
                            </td>
                            <td>
                                <input type="text" class="form-control mb-2 mr-sm-2"  placeholder="Quantity" value="" name="qty">
                            </td>
                            <td>
                                Price per Unity:
                            </td>
                            <td>
                                <input type="text" class="form-control mb-2 mr-sm-2"  placeholder="Price per Unity" value="" name="price">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Product Category:
                            </td>
                            <td>
                                <select name="category" class="form-control mb-2 mr-sm-2">
                                    <option value="Beverages">Beverages</option>
                                    <option value="Condiments">Condiments </option>
                                    <option value="Confections">Confections</option>
                                    <option value="Dairy Products">Dairy Products</option>
                                    <option value="Grains/Cereals">Grains/Cereals</option>
                                    <option value="Meat/Poultry">Meat/Poultry</option>
                                    <option value="Produce">Produce</option>
                                    <option value="Seafood">Seafood</option>
                                </select>
                            </td>
                            <td>
                                Entry Date:
                            </td>
                            <td>
                                <input type="date" class="form-control mb-2 mr-sm-2" value="" name="entryDate">
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
                    <input type="submit" class="btn btn-success" value="Submit" id="add">
                    <input type="hidden" name="form" value="addProductInventory">
                </div>
            </form>
            ';
            return $form;
        }

        /*
        private static function editFormOrder(Order $order){

        }
        */
    }