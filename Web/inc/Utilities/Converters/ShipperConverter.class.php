<?php

class ShipperConverter{

    public static function convertFromStdClass($data){

        try{

            if(is_array($data)){

                $shipperArray = [];

                for($i = 0; $i < count($data); $i++){

                    if( get_class($data[$i]) == "stdClass"){

                        array_push(
                            $shipperArray,
                            self::parseToShipper($data[$i])
                        );

                    } else {
                        
                        throw new Exception("This is not a valid stdClass! - $i");
                    }
                }

                return $shipperArray;

            } else if(get_class($data) == "stdClass"){

                return self::parseToShipper($data);

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

                $shipperArray = [];

                for($i = 0; $i < count($data); $i++){

                    if( get_class($data[$i]) == "Shipper"){

                        array_push(
                            $shipperArray,
                            self::parseToStd($data[$i])
                        );

                    } else {
                        
                        throw new Exception("This is not a valid stdClass! - $i");
                    }
                }

                return $shipperArray;

            } else if(get_class($data) == "Shipper"){

                return self::parseToStd($data);

            } else {
                throw new Exception("This is not a valid stdClass!");
            }

        } catch(Exception $error){
            echo $error->getMessage();
        }
    }

    private static function parseToShipper(stdClass $stdClass) : Shipper{

        $newShipper = new Shipper(
            $stdClass->shipperId,
            $stdClass->shipperName,
            $stdClass->contactName,
            $stdClass->address,
            $stdClass->city,
            $stdClass->country,
            $stdClass->phone,
            $stdClass->email
            //$stdClass->price
        );

        if($stdClass->_id != null){
            $newShipper->setId($stdClass->_id);
        }

        return $newShipper;
    }

    private static function parseToStd(Shipper $newShipper) : stdClass{

        $stdShipper = new stdClass();
        
        $stdShipper->shipperId   = $newShipper->getShipperId();
        $stdShipper->shipperName = $newShipper->getShipperName();
        $stdShipper->contactName = $newShipper->getContactName();
        $stdShipper->address     = $newShipper->getAddress();
        $stdShipper->city        = $newShipper->getCity();
        $stdShipper->country     = $newShipper->getCountry();
        $stdShipper->phone       = $newShipper->getPhone();
        $stdShipper->email       = $newShipper->getEmail();

        if($newShipper->getId() != null){
            $stdShipper->_id = $newShipper->getId();
        }

        return $stdShipper;
    }
}