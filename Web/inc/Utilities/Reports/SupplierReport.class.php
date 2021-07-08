<?php

    class SupplierReport{
        private static $supplierArray;

        public static function getOrderFromDb(){
            $cursor = new Database("Supplier","mongo");

            self::$supplierArray = SupplierConverter::convertFromStdClass($cursor->getDataBase()->findData(
                [],
                5,
                "supplierId"
            ));
            return self::$supplierArray;
        }
    }