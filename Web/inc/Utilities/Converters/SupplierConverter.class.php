<?php
    require_once("inc/Entities/Products/ProductSupplier.class.php");

    class SupplierConverter{

        public static function convertFromStdClass($data){

            try{

                if(is_array($data)){

                    $supplierArray = [];

                    for($i = 0; $i < count($data); $i++){

                        if( get_class($data[$i]) == "stdClass"){          
                            array_push(
                                $supplierArray,
                                self::parseToSupplier($data[$i])
                            );

                        } else {               
                            throw new Exception("This is not a valid stdClass! - $i");
                        }
                    }

                    return $supplierArray;

                } else if(get_class($data) == "stdClass"){
                    return self::parseToSupplier($data);

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

                    $supplierArray = [];

                    for($i = 0; $i < count($data); $i++){

                        if( get_class($data[$i]) == "Supplier"){
                            array_push(
                                $supplierArray,
                                self::parseToStd($data[$i])
                            );

                        } else {
                            throw new Exception("This is not a valid stdClass! - $i");
                        }
                    }

                    return $supplierArray;

                } else if(get_class($data) == "Supplier"){

                    return self::parseToStd($data);

                } else {
                    throw new Exception("This is not a valid stdClass!");
                }

            } catch(Exception $error){
                echo $error->getMessage();
            }
        }

        private static function parseToSupplier(stdClass $stdSupplier) : Supplier{
            $productsArray = [];

            if(is_array($stdSupplier->products)){
                for($j = 0; $j < count($stdSupplier->products); $j++){

                    $newProduct = new ProductSupplier(
                        $stdSupplier->products[$j]->productId,
                        $stdSupplier->products[$j]->productName,
                        $stdSupplier->products[$j]->unity,
                        $stdSupplier->products[$j]->price
                    );
                    
                    array_push($productsArray,$newProduct);
                }
                
            } else {

                $newProduct = new ProductSupplier(
                    $stdSupplier->products->productId,
                    $stdSupplier->products->productName,
                    $stdSupplier->products->unity,
                    $stdSupplier->products->price
                );
                array_push($productsArray,$newProduct);
            }
            

            $newSupplier = new Supplier(
                $stdSupplier->supplierId,
                $stdSupplier->supplierName,
                $stdSupplier->contactName,
                $stdSupplier->address,
                $stdSupplier->city,
                $stdSupplier->country,
                $stdSupplier->phone,
                $stdSupplier->email
            );

            $newSupplier->setProducts($productsArray);

            if($stdSupplier->_id != null){
                $newSupplier->setId($stdSupplier->_id);
            }
            return $newSupplier;

        }

        private static function parseToStd(Supplier $newSupplier) : stdClass{
            $stdSupplier = new stdClass();
            $productsStdArray = [];

            for($j = 0; $j < count($newSupplier->getProducts()); $j++){

                $newProduct = new stdClass();
                $newProduct->productId   = $newSupplier->getProducts()[$j]->getProductId();
                $newProduct->productName = $newSupplier->getProducts()[$j]->getProductName();
                $newProduct->unity       = $newSupplier->getProducts()[$j]->getUnity();
                $newProduct->price       = $newSupplier->getProducts()[$j]->getPrice();        

                array_push($productsStdArray,$newProduct);
            }

            $stdSupplier->supplierId   = $newSupplier->getSupplierId();
            $stdSupplier->supplierName = $newSupplier->getSupplierName();
            $stdSupplier->contactName  = $newSupplier->getContactName();
            $stdSupplier->address      = $newSupplier->getAddress();
            $stdSupplier->city         = $newSupplier->getCity();
            $stdSupplier->country      = $newSupplier->getCountry();
            $stdSupplier->phone        = $newSupplier->getPhone();
            $stdSupplier->email        = $newSupplier->getEmail();
            $stdSupplier->products     = $productsStdArray;

            if($newSupplier->getId() != null){
                $stdSupplier->_id = $newSupplier->getId();
            }

            return $stdSupplier;
        }
    }