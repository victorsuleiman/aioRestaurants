<?php

    class ProductInventoryConverter{
        
        public static function convertFromStdClass($data){
            try{
                if(is_array($data)){

                    $inventoryArray = [];

                    for($i = 0; $i < count($data); $i++){

                        array_push(
                            $inventoryArray,
                            self::parseToProduct($data[$i])
                        );
                    }
                    return $inventoryArray;
                    
                } else if(get_class($data) == "ProductInventory"){

                    return self::parseToProduct($data);

                } else {
                    throw new Exception("This is not a valid stdClass!");
                }
            } catch(Exception $errorMessage){
                echo $errorMessage->getMessage();
            }
        }

        public static function convertToStdClass($data){
            try{
                if(is_array($data)){
                    $inventoryArray = [];

                    for($i = 0; $i < count($data); $i++){
                        

                        array_push(
                            $inventoryArray,
                            self::parseToStd($data[$i])
                        );
                    }
                    
                    return $inventoryArray;

                } else if(get_class($data) == "ProductInventory"){

                    return self::parseToStd($data);
                } else {
                    
                    throw new Exception("This is not a valid Inventory object!");
                }
            }catch(Exception $errorMessage){
                echo $errorMessage->getMessage();
            }
        }

        private static function parseToProduct($stdClass) : ProductInventory{

            $newProduct = new ProductInventory(
                $stdClass->productId,
                $stdClass->productName,
                $stdClass->unity,
                $stdClass->supplierId,
                $stdClass->qty,
                $stdClass->price,
                $stdClass->category,
                $stdClass->entryDate,
                $stdClass->withdrawalDate
            );
            if($stdClass->_id != null){
                $newProduct->setId($stdClass->_id);
            }
            return $newProduct;
        }

        private static function parseToStd(ProductInventory $nProduct) : stdClass{

            $newProduct = new stdClass();
            $newProduct->productId      = $nProduct->getProductId();
            $newProduct->productName    = $nProduct->getProductName();
            $newProduct->unity          = $nProduct->getUnit();
            $newProduct->qty            = $nProduct->getQuantity();
            $newProduct->price          = $nProduct->getPrice();
            $newProduct->category       = $nProduct->getCategory();
            $newProduct->entryDate      = $nProduct->getEntryDate();
            $newProduct->withdrawalDate = $nProduct->getOutDate();

            if($nProduct->getId() != null){
                $newProduct->_id = $nProduct->getId();
            }

            return $newProduct;
        }
    }