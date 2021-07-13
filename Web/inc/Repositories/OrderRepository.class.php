<?php
    
    class OrderRepository{
        private static $orderCollection = [];

        public static function getorderCollection(){
            return self::$orderCollection;
        }

        public static function addOrder(Order $nOrder){
            try{
                if(get_class($nOrder) == "Order"){
                    array_push(self::$orderCollection,$nOrder);
                } else {
                    throw new Exception("This is not an Order object!");
                }
            } catch(Exception $error){
                echo $error->getMessage();
            }
            
        }

        public static function addAllOrders($nOrder){
            try{
                if(!is_array($nOrder)){
                    throw new Exception("This is not an array!");
                } else {
                    for($i = 0; $i < count($nOrder); $i++){
                        array_push(self::$orderCollection,$nOrder[$i]);
                    }
                }
            } catch(Exception $error) {
                echo $error->getMessage();
            }
        }

        public static function updateOrder(Order $nOrder){
            try{
                if(get_class($nOrder) == "Order"){
                    
                    for($i = 0; $i < count(self::$orderCollection); $i++){
                        if(
                        self::$orderCollection[$i]->getOrderId() == $nOrder->getOrderId()
                        ){
                            self::$orderCollection[$i] = $nOrder;
                            break;
                        } else if($i == count(self::$orderCollection)-1){
                            echo "Id not found!";
                        }
                    }
                } else {
                    throw new Exception("This is not an Order object!");
                }
            } catch(Exception $error){
                echo $error->getMessage();
            }
        }

        public static function deleteOrder(int $orderId){
            try{
                if(is_numeric($orderId)){
                    for($i = 0; $i < count(self::$orderCollection); $i++){
                        if(
                            self::$orderCollection[$i]->getOrderId() == $orderId
                        ){
                            unset(self::$orderCollection[$i]);
                            break;
                        } else if($i == count(self::$orderCollection)-1){
                            echo "Id not found!";
                        }
                    }
                } else {
                    throw new Exception("This is not a valid id!");
                }
            } catch(Exception $error){
                echo $error->getMessage();
            }
        }
    }