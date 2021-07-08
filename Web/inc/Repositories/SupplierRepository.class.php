<?php

    class SupplierRepository{
        private static $supplierCollection = [];

        public static function getSupplierCollection(){
            return self::$supplierCollection;
        }

        public static function addSupplier(Supplier $nSupplier){
            try{
                if(get_class($nSupplier) == "Supplier"){
                    array_push(self::$supplierCollection,$nSupplier);
                } else {
                    throw new Exception("This is not an Supplier object!");
                }
            } catch(Exception $error){
                echo $error->getMessage();
            }
            
        }

        public static function addAllSuppliers($nSupplier){
            try{
                if(!is_array($nSupplier)){
                    throw new Exception("This is not an array!");
                } else {
                    for($i = 0; $i < count($nSupplier); $i++){
                        array_push(self::$supplierCollection,$nSupplier[$i]);
                    }
                }
            } catch(Exception $error) {
                echo $error->getMessage();
            }
        }

        public static function updateSupplier(Supplier $nSupplier){
            try{
                if(get_class($nSupplier) == "Supplier"){
                    
                    for($i = 0; $i < count(self::$supplierCollection); $i++){
                        if(
                        self::$supplierCollection[$i]->getSupplierId() == $nSupplier->getSupplierId()
                        ){
                            self::$supplierCollection[$i] = $nSupplier;
                            break;
                        } else if($i == count(self::$supplierCollection)-1){
                            echo "Id not found!";
                        }
                    }
                } else {
                    throw new Exception("This is not an Supplier object!");
                }
            } catch(Exception $error){
                echo $error->getMessage();
            }
        }

        public static function deleteSupplier(int $supplierId){
            try{
                if(is_numeric($supplierId)){
                    for($i = 0; $i < count(self::$supplierCollection); $i++){
                        if(
                            self::$supplierCollection[$i]->getSupplierId() == $supplierId
                        ){
                            unset(self::$supplierCollection[$i]);
                            break;
                        } else if($i == count(self::$supplierCollection)-1){
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