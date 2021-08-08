<?php

require_once("inc/config.inc.php");
require_once("inc/Database/Database.class.php");

require_once("inc/Utilities/Dao/EmployeeDAO.class.php");
require_once("inc/Utilities/Dao/SupplierDAO.class.php");
require_once("inc/Utilities/Dao/OrderDAO.class.php");
require_once("inc/Utilities/Dao/ShipperDAO.class.php");
require_once("inc/Utilities/Dao/ProductInventoryDAO.class.php");
require_once("inc/Utilities/Dao/ReceiptDAO.class.php");

require_once("inc/Utilities/Converters/EmloyeeConverter.class.php");
require_once("inc/Utilities/Converters/SupplierConverter.class.php");
require_once("inc/Utilities/Converters/OrderConverter.class.php");
require_once("inc/Utilities/Converters/ShipperConverter.class.php");
require_once("inc/Utilities/Converters/ProductInventoryConverter.class.php");
require_once("inc/Utilities/Converters/UserSessionConverter.class.php");
require_once("inc/Utilities/Converters/ReceiptConverter.class.php");

require_once("inc/Utilities/ParsePostForm.class.php");

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
                
                case "receipt":
                    ReceiptDAO::startDb();
                    return ReceiptDAO::getMultipleReceipts($limit);
            }
        }

        public static function postData($post){
            $collection = ParsePostForm::parsePost($post);
            $class = get_class($collection);

            switch(strtolower($class)){
                case "employee":
                    EmployeeDAO::startDb();
                    EmployeeDAO::insert($collection);
                    break;

                case "shipper":
                    ShipperDAO::startDb();
                    ShipperDAO::insert($collection);
                    break;
                
                case "productinventory":
                    ProductInventoryDAO::startDb();
                    ProductInventoryDAO::insert($collection);
                    break;

                case "order":
                    OrderDAO::startDb();
                    OrderDAO::insert($collection);
                    break;

                case "supplier":
                    SupplierDAO::startDb();
                    SupplierDAO::insert($collection);
                    break;
            }
        }

        public static function deleteData($post){
            $collection = ParsePostForm::parsePost($post);
            $class = get_class($collection);

            switch(strtolower($class)){
                case "employee":
                    EmployeeDAO::startDb();
                    EmployeeDAO::delete($collection);
                    break;

                case "shipper":
                    ShipperDAO::startDb();
                    ShipperDAO::delete($collection);
                    break;
                
                case "productinventory":
                    ProductInventoryDAO::startDb();
                    ProductInventoryDAO::delete($collection);
                    break;

                case "order":
                    OrderDAO::startDb();
                    OrderDAO::delete($collection);
                    break;

                case "supplier":
                    SupplierDAO::startDb();
                    SupplierDAO::delete($collection);
                    break;
            }
        }

        public static function updateData($post){
            $collection = ParsePostForm::parsePost($post);
            $class = get_class($collection);

            switch(strtolower($class)){
                case "employee":
                    EmployeeDAO::startDb();
                    EmployeeDAO::update($collection);
                    break;

                case "shipper":
                    ShipperDAO::startDb();
                    ShipperDAO::update($collection);
                    break;
                
                case "productinventory":
                    ProductInventoryDAO::startDb();
                    ProductInventoryDAO::update($collection);
                    break;

                case "order":
                    OrderDAO::startDb();
                    OrderDAO::update($collection);
                    break;

                case "supplier":
                    SupplierDAO::startDb();
                    SupplierDAO::update($collection);
                    break;
            }
        }
        
        public static function getUser($username){
            EmployeeDAO::startDb();
            return EmployeeDAO::getUser($username);
        }

        //Return a stdClass with ->_id and ->email
        public static function getEmail(){
            EmployeeDAO::startDb();
            return EmployeeDAO::existEmail("colliffea@instagram.com");
        }

        public static function getReciptReport($post,$sort){
            $dateArray = ParsePostForm::parseDate($post);

            $date = [
                "gt" => $dateArray[0],
                "lt" => $dateArray[1]
            ];

            ReceiptDAO::startDb();
            return ReceiptDAO::getReciptsWeeklyReport($date,$sort);
        }

        public static function getGoal($post){
            $dateArray = ParsePostForm::parseDate($post);

            $date = [
                "gt" => $dateArray[0],
                "lt" => $dateArray[1]
            ];

            ReceiptDAO::startDb();
            return ReceiptDAO::getDateGoals($date);
        }
    }