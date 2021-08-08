<?php

    require_once("inc/Entities/Order.class.php");
    require_once("inc/Entities/Employee.class.php");
    require_once("inc/Entities/Supplier.class.php");
    require_once("inc/Entities/Shipper.class.php");
    require_once("inc/Entities/Products/ProductInventory.class.php");
    require_once("inc/Entities/UserSession.class.php");
    require_once("inc/Entities/Dish.class.php");
    require_once("inc/Entities/Receipt.class.php");

    class ParsePostForm {

        public static function parsePost(Array $post) {
            $collection = $post["form"];
            
            switch($collection) {

                case "addEmployee" || "editEmployee":
                    return self::parseEmployee($post);

                case "addOrder" || "editOrder":
                    return self::parseOrder($post);

                case "addShipper" || "editShipper":
                    return self::parseShipper($post);

                case "addProductInventory" || "editProductInventory":
                    return self::parseProduct($post);

                case "addSupplier" || "editSupplier":
                    return self::parseSupplier($post);

                /*
                case "dateReport":
                    var_dump(self::parseDate($post));
                */
                default:
                    break;
                    
                /*
                case "userLogin":
                    return self::parseUser($post);
                */
            }
        }

        private static function parseEmployee($post) : Employee {

            $newEmployee = new Employee(
                0,
                $post["firstName"],
                $post["lastName"],
                $post["bDate"],
                $post["address"],
                $post["city"],
                $post["phone"],
                $post["email"],
                "",
                $post["notes"],
                $post["userCategory"],
                $post["username"],
                password_hash($post["password"], PASSWORD_DEFAULT)
            );

            if(isset($post["employeeId"])){
                $newEmployee->setEmployeeId($post["employeeId"]);
            }

            if(isset($post["_id"])){
                $newEmployee->setId($post["_id"]);
            }
            
            return $newEmployee;
        }

        private static function parseOrder($post) : Order {
            $newOrder = new Order(
                0,
                $post["supplierId"],
                $post["orderDate"],
                $post["deliveryDate"],
                $post["employeeId"],
                0,/*$post["shipperId"]*/
                []/*$nProducts = []*/
            );

            if(isset($post["orderId"])){
                $newOrder->setOrderId($post["orderId"]);
            }

            $newOrder->setId($post["_id"]);

            return $newOrder;
        }

        private static function parseShipper($post) : Shipper {
            $newShipper = new Shipper(
                0,
                $post["shipperName"],
                $post["contactName"],
                $post["address"],
                $post["city"],
                $post["country"],
                $post["phone"],
                $post["email"],
                $post["price"]
            );

            $newShipper->setId($post["_id"]);

            if(isset($post["shipperId"])){
                $newShipper->setShipperId($post["shipperId"]);
            }

            return $newShipper;
        }

        private static function parseProduct($post) : Product {
            $newProduct = new ProductInventory(
                0,
                $post["productName"],
                $post["unit"],
                $post["supplierId"],
                $post["qty"],
                $post["price"],
                $post["category"],
                $post["entryDate"]
            );

            $newProduct->setId($post["_id"]);

            if(isset($post["productId"])){
                $newProduct->setProductId($post["productId"]);
            }

            return $newProduct;
        }

        private static function parseSupplier($post) : Supplier {
            $newSupplier = new Supplier(
                0,
                $post["supplierName"],
                $post["contactName"],
                $post["address"],
                $post["city"],
                /*$post["postalCode"],*/
                $post["country"],
                $post["phone"],
                $post["email"],
                []
            );

            if(isset($post["supplierId"])){
                $newSupplier->setSupplierId($post["supplierId"]);
            }

            $newSupplier->setId($post["_id"]);

            return $newSupplier;
        }

        public static function parseDate($post){
            $date = explode("#",$post["weekGoalReport"]);
            return $date;
        }
    }