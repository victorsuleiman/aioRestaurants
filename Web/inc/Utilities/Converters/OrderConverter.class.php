<?php

    require_once("inc/Entities/Products/ProductOrder.class.php");
    class OrderConverter{

        public static function convertFromStdClass($data){

            try{

                if(is_array($data)){

                    $orderArray = [];

                    for($i = 0; $i < count($data); $i++){

                        if( get_class($data[$i]) == "stdClass"){
                            array_push(
                                $orderArray,
                                self::parseToOrder($data[$i])
                            );
                        } else {
                            throw new Exception("This is not a valid stdClass! - $i");
                        }
                    }

                    return $orderArray;

                } else if(get_class($data) == "stdClass"){

                    return self::parseToOrder($data);

                } else {
                    throw new Exception("This is not a valid stdClass!");
                }

            } catch(Exception $error){
                echo $error->getMessage();
            }
        }

        public static function convertToStdClass($data){
            try{
                if(is_array($data)){

                    $orderArray = [];

                    for($i = 0; $i < count($data); $i++){

                        if(get_class($data[$i]) == "Order"){
                            array_push(
                                $orderArray,
                                self::parseToStd($data[$i])
                            );
                        } else {
                            throw new Exception("This is not a valid Order object!");
                        }
                        
                    }

                    return $orderArray;

                } else if(get_class($data) == "Order") {

                    return self::parseToStd($data);

                } else {
                    throw new Exception("This is not a valid Order object!");
                }
            } catch(Exception $errorMessage){
                echo $errorMessage->getMessage();
            }
        }

        private static function parseToOrder($stdClass) : Order {
            $productsArray = [];

            if(is_array($stdClass->product)) {
                for($j = 0; $j < count($stdClass->product); $j++){

                    $newProduct = new ProductOrder(
                        $stdClass->product[$j]->productId,
                        $stdClass->product[$j]->productName,
                        $stdClass->product[$j]->unity,
                        $stdClass->product[$j]->price,
                        $stdClass->product[$j]->qty
                    );
    
                    array_push($productsArray,$newProduct);
                }
            } else {
                $newProduct = new ProductOrder(
                    $stdClass->products->productId,
                    $stdClass->products->productName,
                    $stdClass->products->unity,
                    $stdClass->products->price,
                    $stdClass->products->qty
                );

                array_push($productsArray,$newProduct);
            }

            $newOrder = new Order (
                $stdClass->orderId,
                $stdClass->supplierId,
                $stdClass->orderDate,
                $stdClass->estimateDelivery,
                $stdClass->employeeId,
                $stdClass->shipperId
            );
            $newOrder->setProducts($productsArray);

            if($stdClass->_id != null){
                $newOrder->setId($stdClass->_id);
            }

            return $newOrder;
        }

        private static function parseToStd(Order $nOrder) : stdClass {
            $stdOrder = new stdClass();
            $productsArray = [];

            for($j = 0; $j < count($nOrder->getProducts()); $j++){

                $newProduct = new stdClass();
                $newProduct->productId   = $nOrder->getProducts()[$j]->getProductId();
                $newProduct->productName = $nOrder->getProducts()[$j]->getProductName();
                $newProduct->unity       = $nOrder->getProducts()[$j]->getUnity();
                $newProduct->price       = $nOrder->getProducts()[$j]->getPrice();
                $newProduct->qty         = $nOrder->getProducts()[$j]->getQuantity();

                array_push($productsArray,$newProduct);
            }
            
            if($nOrder->getId() != null){
                $stdOrder->_id = $nOrder->getId();
            }
            $stdOrder->orderId = $nOrder->getOrderId();
            $stdOrder->supplierId = $nOrder->getSupplierId();
            $stdOrder->orderDate = $nOrder->getOrderDate();
            $stdOrder->estimateDelivery = $nOrder->getEstimateDeliveryDate();
            $stdOrder->employeeId = $nOrder->getEmployeeId();
            $stdOrder->shipperId = $nOrder->getShipperId();
            $stdOrder->products = $productsArray;
            
            return $stdOrder;
        }
    }