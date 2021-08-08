<?php

    class ReceiptDAO{
        private static $connection;

        public static function startDb($dataBase = "mongo"){
            self::$connection = new Database("Receipt",$dataBase);
        }

        public static function insert(Receipt $newReceipt){

            if( get_class(self::$connection->getDataBase()) == "PDOMongo"){

                return self::$connection->getDataBase()->insertData(
                    ReceiptConverter::convertToStdClass($newReceipt)
                );
                
            }
        }

        public static function getRecipt($_id) : Receipt {
            if( get_class(self::$connection->getDataBase()) == "PDOMongo"){

                $receiptArray = ReceiptConverter::convertFromStdClass(
                    self::$connection->getDataBase()::findData("_id",$_id)
                );
    
                return $receiptArray;
            }
        }

        public static function getMultipleReceipts($limit = 5){
            if( get_class(self::$connection->getDataBase()) == "PDOMongo"){

                $receiptArray = ReceiptConverter::convertFromStdClass(
                    self::$connection->getDataBase()::findData([],$limit)
                );
    
                return $receiptArray;
            }
                
        }

        public static function getReciptsWeeklyReport($date,$sort){
            $receiptArray = ReceiptConverter::convertFromStdClass(
                self::$connection->getDatabase()::getDates($date,$sort)
            );

            return $receiptArray;
        }

        public static function getDateGoals($date){
            return self::$connection->getDatabase()::getGoals($date);
        }
    }