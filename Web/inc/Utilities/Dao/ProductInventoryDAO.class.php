<?php

    class ProductInventoryDAO{
        private static $connection;

        public static function startDb($database = "mongo"){
            self::$connection = new Database("ProductInventory",$database);
        }

        public static function insert(ProductInventory $newProduct){

            if( get_class(self::$connection->getDataBase()) == "PDOMongo"){

                $id = self::$connection->getDatabase()->getCounter();
                $newProduct->setProductId($id);

                return self::$connection->getDataBase()->insertData(
                    ProductInventoryConverter::convertToStdClass(
                        $newProduct
                    )
                );

            } else {
                
                $sqlInsert  = "INSERT INTO productInventory (";
                $sqlInsert .= "orderId, quantity, sellPrice, category,";
                $sqlInsert .= " entryDate, outDate";
                $sqlInsert .= "VALUES (";
                $sqlInsert .= ":id, :qty, :price, :category, :entry,";
                $sqlInsert .= " :out);";

                self::$connection->getDatabase()->query(
                    $sqlInsert
                );

                $bindData = [
                    ':id' => $newProduct->getProductId(),
                    ':qty' => $newProduct->getQuantity(),
                    ':price' => $newProduct->getPrice(),
                    ':entry' => $newProduct->getEntryDate(),
                    ':out' => $newProduct->getOutDate()
                ];

                self::$connection->execute(
                    $bindData
                );

                return self::$connection->lastInsertedId();
            }
        }

        public static function update(ProductInventory $newProduct){

            if( get_class(self::$connection->getDataBase()) == "PDOMongo"){
                return self::$connection->getDataBase()->updateData(
                    ProductInventoryConverter::convertToStdClass($newProduct)
                );

            } else {

                $sqlUpdate  = "UPDATE productInventory SET";
                $sqlUpdate .= " quantity =:qty, sellPrice =:price,";
                $sqlUpdate .= " category =:category, entryDate =:entry,";
                $sqlUpdate .= " phone =:phone, email =:email,";
                $sqlUpdate .= " outDate =:out WHERE productId =:id;";

                self::$connection->getDatabase()->query(
                    $sqlUpdate
                );

                $bindData = [
                    ':id' => $newProduct->getProductId(),
                    ':qty' => $newProduct->getQuantity(),
                    ':price' => $newProduct->getPrice(),
                    ':entry' => $newProduct->getEntryDate(),
                    ':out' => $newProduct->getOutDate()
                ];

                self::$connection->execute(
                    $bindData
                );

                return self::$connection->lastInsertedId();
            }

        }

        public static function delete(ProductInventory $newProduct){

            if( get_class(self::$connection->getDataBase()) == "PDOMongo"){

                return self::$connection->getDataBase()->deleteData(
                    ProductInventoryConverter::convertToStdClass($newProduct)
                );

            } else {    
                $deleteQuery = "DELETE FROM productInventory WHERE productId = :id";

                self::$connection->getDatabase()->query(
                    $deleteQuery
                );
               
                self::$connection->getDatabase()->bind(
                    ':id', $newProduct->getProductId()
                );

                self::$connection->execute();
                return true;
            }
        }

        public static function getProductInventory($_id){

            if( get_class(self::$connection->getDataBase()) == "PDOMongo"){

                self::$connection->getDatabase()->bindElement("productId",$_id);
                $newProduct = ProductInventoryConverter::convertFromStdClass(
                    self::$connection->getDataBase()::findData(
                        [],
                        1
                    )
                );
                return $newProduct;

            } else {
                $sqlSelect = "SELECT * FROM productInventory WHERE productId =:id";

                self::$connection->getDatabase()->query($sqlSelect);
                self::$connection->getDatabase()->bind(':id',$_id);
                self::$connection->getDatabase()->execute();

                return self::$connection->singleResult();
            }
                   
        }

        public static function getMultipleProducts($limit = 0){

            if( get_class(self::$connection->getDataBase()) == "PDOMongo"){

                $productArray = ProductInventoryConverter::convertFromStdClass(
                    self::$connection->getDataBase()::findData([],$limit)
                );
    
                return $productArray;
            } else {
                $sqlSelectAll = "SELECT * FROM productInventory";

                self::$connection->getDatabase()->query(
                    $sqlSelectAll
                );

                self::$connection->getDatabase()->execute();
                return self::$connection->getDatabase()->resultSet();
            }
            
        }
    }