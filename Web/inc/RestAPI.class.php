<?php

require_once("inc/config.inc.php");
require_once("inc/Database/Database.class.php");

// require_once("inc/Entities/Order.class.php");
// require_once("inc/Entities/Employee.class.php");
// require_once("inc/Entities/Supplier.class.php");
// require_once("inc/Entities/Shipper.class.php");
// require_once("inc/Entities/Products/ProductInventory.class.php");

require_once("inc/Utilities/Converters/EmloyeeConverter.class.php");
require_once("inc/Utilities/Converters/SupplierConverter.class.php");
require_once("inc/Utilities/Converters/OrderConverter.class.php");
require_once("inc/Utilities/Converters/ShipperConverter.class.php");
require_once("inc/Utilities/Converters/ProductInventoryConverter.class.php");

require_once("inc/Utilities/Dao/EmployeeDAO.class.php");
require_once("inc/Utilities/Dao/SupplierDAO.class.php");
require_once("inc/Utilities/Dao/OrderDAO.class.php");
require_once("inc/Utilities/Dao/ShipperDAO.class.php");
require_once("inc/Utilities/Dao/ProductInventoryDAO.class.php");

    class RestAPI{
        
        public static function getData($collection,$limit=5){
            $collection = strtolower($collection);

            switch($collection){
                case "employee":
                    EmployeeDAO::startDb();
                    return EmployeeDAO::getMultipleEmployee($limit);

                case "shipper":
                    ShipperDAO::startDb();
                    return ShipperDAO::getMultipleShipper($limit);
                
                case "productinventory":
                    ProductInventoryDAO::startDb();
                    return ProductInventoryDAO::getMultipleProducts($limit);

                case "order":
                    OrderDAO::startDb();
                    return OrderDAO::getMultipleOrders($limit);

                case "supplier":
                    SupplierDAO::startDb();
                    return SupplierDAO::getMultipleSupplier($limit);
            }
        }

        public static function postData($collection){
            $class = get_class($collection);

            switch(strtolower($class)){
                case "employee":
                    EmployeeDAO::startDb();
                    EmployeeDAO::insert($collection);
                    self::toastAdded();
                    break;

                case "shipper":
                    ShipperDAO::startDb();
                    ShipperDAO::insert($collection);
                    self::toastAdded();
                    break;
                
                case "productinventory":
                    ProductInventoryDAO::startDb();
                    ProductInventoryDAO::insert($collection);
                    self::toastAdded();
                    break;

                case "order":
                    OrderDAO::startDb();
                    OrderDAO::insert($collection);
                    self::toastAdded();
                    break;

                case "supplier":
                    SupplierDAO::startDb();
                    SupplierDAO::insert($collection);
                    self::toastAdded();
                    break;
            }
        }

        public static function deleteData($collection){
            $class = get_class($collection);

            switch(strtolower($class)){
                case "employee":
                    EmployeeDAO::startDb();
                    EmployeeDAO::delete($collection);
                    self::toastDeleted();
                    break;

                case "shipper":
                    ShipperDAO::startDb();
                    ShipperDAO::delete($collection);
                    self::toastDeleted();
                    break;
                
                case "productinventory":
                    ProductInventoryDAO::startDb();
                    ProductInventoryDAO::delete($collection);
                    self::toastDeleted();
                    break;

                case "order":
                    OrderDAO::startDb();
                    OrderDAO::delete($collection);
                    self::toastDeleted();
                    break;

                case "supplier":
                    SupplierDAO::startDb();
                    SupplierDAO::delete($collection);
                    self::toastDeleted();
                    break;
            }
        }

        public static function updateData($collection){
            $class = get_class($collection);

            switch(strtolower($class)){
                case "employee":
                    EmployeeDAO::startDb();
                    EmployeeDAO::update($collection);
                    self::toastUpdate();
                    break;

                case "shipper":
                    ShipperDAO::startDb();
                    ShipperDAO::update($collection);
                    self::toastUpdate();
                    break;
                
                case "productinventory":
                    ProductInventoryDAO::startDb();
                    ProductInventoryDAO::update($collection);
                    self::toastUpdate();
                    break;

                case "order":
                    OrderDAO::startDb();
                    OrderDAO::update($collection);
                    self::toastUpdate();
                    break;

                case "supplier":
                    SupplierDAO::startDb();
                    SupplierDAO::update($collection);
                    self::toastUpdate();
                    break;
            }
        }


        private static function toastAdded(){
            $toast = '
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body">
                    Hello, world! This is a toast message.
                    <div class="mt-2 pt-2 border-top">
                        <button type="button" class="btn btn-success btn-sm" data-bs-dismiss="toast">
                            Data added successfully!
                        </button>
                    </div>
                </div>
            </div>
            ';
        }

        private static function toastUpdate(){
            $toast = '
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body">
                    Hello, world! This is a toast message.
                    <div class="mt-2 pt-2 border-top">
                        <button type="button" class="btn btn-success btn-sm" data-bs-dismiss="toast">
                            Data updated successfully!
                        </button>
                    </div>
                </div>
            </div>
            ';
        }

        private static function toastDeleted(){
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
        }
    }