<?php

    class OrderReport{

        private static $orderArray;

        public static function getOrderFromDb(){
            $cursor = new Database("Order","mongo");

            self::$orderArray = OrderConverter::convertFromStdClass($cursor->getDataBase()->findData(
                [],
                5,
                "orderId"
            ));
            return self::$orderArray;
        }

        private static function getProductArray(){
            self::getOrderFromDb();
            $productArray = [];

            for($i = 0; $i < count(self::$orderArray); $i++){
                for($j = 0; $j < count(self::$orderArray[$i]->getProducts()); $j++){
                    $productArray[] = self::$orderArray[$i]->getProducts()[$j];
                }
            }

            return $productArray;
        }

        public static function getProductsFromOrder(){
            $currentArray = self::getProductArray();
            $newArray = [];
            for($i = 0; $i < count($currentArray); $i++){
                
                if(!empty($newArray)){

                    if(self::productExist($newArray,$currentArray[$i]) >= 0){
                        $newQty  = $newArray[self::productExist($newArray,$currentArray[$i])]->getQuantity();
                        $newQty += $currentArray[$i]->getQuantity();
                        $newArray[self::productExist($newArray,$currentArray[$i])]->setQuantity($newQty);
                    } else {
                        $newArray[] = $currentArray[$i];
                    }

                } else {
                    $newArray[] = $currentArray[$i];
                }
                
            }

            return $newArray;
        }

        private static function productExist(Array $arr, $prod){
            $valid = -1;
            for($i = 0; $i < count($arr); $i++){

                if ( $arr[$i]->getProductId() == $prod->getProductId() ){
                    $valid = $i;
                    break;
                }
            }

            return $valid;
        }
    }