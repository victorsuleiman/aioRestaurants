<?php

    require_once("inc/Entities/Order.class.php");
    require_once("inc/Entities/Employee.class.php");
    require_once("inc/Entities/Supplier.class.php");
    require_once("inc/Entities/Shipper.class.php");
    require_once("inc/Entities/Products/ProductInventory.class.php");

    class ParsePostForm{

        public static function parsePost(Array $post){
            $collection = $post["form"];

            switch($collection){
                
                case "addEmployee":
                    return self::parseEmployee($post);

                case "addOrder":
                    return self::parseOrder($post);

                case "addShipper":
                    return self::parseShipper($post);

                case "addProductInventory":
                    return self::parseProduct($post);

                case "addSupplier":
                    return self::parseSupplier($post);

            }
        }

        private static function parseEmployee($post) : Employee{
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
                $post["password"]
            );

            return $newEmployee;
        }

        private static function parseOrder($post) : Order{
            $newOrder = new Order(
                0,
                $post["supplierId"],
                $post["orderDate"],
                $post["deliveryDate"],
                $post["employeeId"],
                0,/*$post["shipperId"]*/
                []/*$nProducts = []*/
            );
            return $newOrder;
        }

        private static function parseShipper($post) : Shipper{
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
            return $newShipper;
        }

        private static function parseProduct($post) : Product{
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
            return $newSupplier;
        }
    }