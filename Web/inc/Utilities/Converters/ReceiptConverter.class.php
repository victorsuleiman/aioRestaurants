<?php

    class ReceiptConverter{

        public static function convertFromStdClass($data){
            try{
                if(is_array($data)){
                    $receiptArray = [];

                    for($i = 0; $i < count($data); $i++){
                        if( get_class($data[$i]) == "stdClass"){
                            $receiptArray[] = self::parseToReceipt($data[$i]);
                        }
                    }
                    return $receiptArray;
                } else if(get_class($data) == "stdClass") {
                    return self::parseToReceipt($data);
                } else {
                    throw new Exception("This is not a valid stdClass!");
                }
            } catch (Exception $error){
                echo $error->getMessage();
            }
        }

        public static function convertToStdClass($data){
            try{
                if(is_array($data)){
                    $receiptArray = [];

                    for($i = 0; $i < count($data); $i++){
                        if( get_class($data[$i]) == "stdClass"){
                            $receiptArray[] = self::parseToStd($data[$i]);
                        }
                    }
                    return $receiptArray;
                } else if(get_class($data) == "stdClass") {
                    return self::parseToStd($data);
                } else {
                    throw new Exception("This is not a valid stdClass!");
                }
            } catch (Exception $error){
                echo $error->getMessage();
            }
        }
        
        private static function parseToStd(Receipt $nReceipt) : stdClass {
            $dishesArray = [];

            for($i = 0; $i < count($nReceipt->getDishes()); $i++){
                $stdDish = new stdClass();
                $stdDish->name = $nReceipt->getDishes()[$i]->name;
                $stdDish->price = $nReceipt->getDishes()[$i]->price;
                $stdDish->qty = $nReceipt->getDishes()[$i]->qty;

                $dishesArray[] = $stdDish;
            }

            $stdClass = new stdClass();
            $stdClass->server = $nReceipt->getServer();
            $stdClass->emploeeId = $nReceipt->getEmployeeId();
            $stdClass->taxes = $nReceipt->getTaxes();
            $stdClass->total = $nReceipt->getTotal();
            $stdClass->paymentType = $nReceipt->getPaymentType();
            $stdClass->date = $nReceipt->getDate();
            $stdClass->dishes = $dishesArray;

            return $stdClass;
        }
        
        private static function parseToReceipt(stdClass $stdClass) : Receipt {
            $dishesArray = [];

            if(is_array($stdClass->dishes)){
                for($i = 0; $i < count($stdClass->dishes); $i++){
                    $dishesArray[] = new Dish(
                        $stdClass->dishes[$i]->name,
                        $stdClass->dishes[$i]->price,
                        $stdClass->dishes[$i]->qty
                    );
                }
            } else {
                $dishesArray[] = $stdClass->dishes;
            }

            $newReceipt = new Receipt(
                $stdClass->server,
                $stdClass->employeeId,
                $stdClass->taxes,
                $stdClass->total,
                $stdClass->paymentType,
                $stdClass->date
            );

            $newReceipt->setDishes($dishesArray);

            if(isset($stdClass->_id)){
                $newReceipt->setId($stdClass->_id);
            }

            return $newReceipt;
        }
    }