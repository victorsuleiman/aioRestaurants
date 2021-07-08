<?php

    class InventoryRepository{
        private static $inventoryCollection = [];

        public static function getorderCollection(){
            return self::$inventoryCollection;
        }

        public static function addProductInventory(ProductInventory $nProduct){
            try{
                if(get_class($nProduct) == "ProductInventory"){
                    array_push(self::$inventoryCollection,$nProduct);
                } else {
                    throw new Exception("This is not an ProductInventory object!");
                }
            } catch(Exception $error){
                echo $error->getMessage();
            }
            
        }

        public static function addAllProductInventory($nProduct){
            try{
                if(!is_array($nProduct)){
                    throw new Exception("This is not an array!");
                } else {
                    for($i = 0; $i < count($nProduct); $i++){
                        array_push(self::$inventoryCollection,$nProduct[$i]);
                    }
                }
            } catch(Exception $error) {
                echo $error->getMessage();
            }
        }

        public static function updateProductInventory(ProductInventory $nProduct){
            try{
                if(get_class($nProduct) == "ProductInventory"){
                    
                    for($i = 0; $i < count(self::$inventoryCollection); $i++){
                        if(
                        self::$inventoryCollection[$i]->getProductId() == $nProduct->getProductId()
                        ){
                            self::$inventoryCollection[$i] = $nProduct;
                            break;
                        }  else if($i == count(self::$inventoryCollection)-1){
                            echo "Id not found!";
                        }
                    }
                } else {
                    throw new Exception("This is not an ProductInventory object!");
                }
            } catch(Exception $error){
                echo $error->getMessage();
            }
        }

        public static function deleteProductInventory(int $productId){
            try{
                if(is_numeric($productId)){
                    for($i = 0; $i < count(self::$inventoryCollection); $i++){

                        if(
                            self::$inventoryCollection[$i]->getProductId() == $productId
                        ){
                            unset(self::$inventoryCollection[$i]);
                            break;
                        } else if($i == count(self::$inventoryCollection)){
                            echo "Id Not found!";
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