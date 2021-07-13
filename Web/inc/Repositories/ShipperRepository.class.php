<?php

    class ShipperRepository{
        private static $shipperCollection = [];

        public static function getShipperCollection(){
            return self::$shipperCollection;
        }

        public static function addShipper(Shipper $nShipper){
            try{
                if(get_class($nShipper) == "Shipper"){
                    array_push(self::$shipperCollection,$nShipper);
                } else {
                    throw new Exception("This is not an Shipper object!");
                }
            } catch(Exception $error){
                echo $error->getMessage();
            }
            
        }

        public static function addAllShippers($nShipper){
            try{
                if(!is_array($nShipper)){
                    throw new Exception("This is not an array!");
                } else {
                    for($i = 0; $i < count($nShipper); $i++){
                        array_push(self::$shipperCollection,$nShipper[$i]);
                    }
                }
            } catch(Exception $error) {
                echo $error->getMessage();
            }
        }

        public static function updateShipper(Shipper $nShipper){
            try{
                if(get_class($nShipper) == "Shipper"){
                    
                    for($i = 0; $i < count(self::$shipperCollection); $i++){
                        if(
                        self::$shipperCollection[$i]->getShipperId() == $nShipper->getShipperId()
                        ){
                            self::$shipperCollection[$i] = $nShipper;
                            break;
                        } else if($i == count(self::$shipperCollection)-1){
                            echo "Id not found!";
                        }
                    }
                } else {
                    throw new Exception("This is not an Shipper object!");
                }
            } catch(Exception $error){
                echo $error->getMessage();
            }
        }

        public static function deleteShipper(int $shipperId){
            try{
                if(is_numeric($shipperId)){
                    for($i = 0; $i < count(self::$shipperCollection); $i++){
                        if(
                            self::$shipperCollection[$i]->getShipperId() == $shipperId
                        ){
                            unset(self::$shipperCollection[$i]);
                            break;
                        } else if($i == count(self::$shipperCollection)-1){
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