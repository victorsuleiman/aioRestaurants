<?php
    require_once("inc/Entities/Products/ProductSupplier.class.php");

    class SupplierDAO{
        
        private static $connection;

        public static function startDb($database = "mongo"){
            self::$connection = new Database("Supplier",$database);
        }

        public static function insert(Supplier $newSupplier){

            if( get_class(self::$connection->getDataBase()) == "PDOMongo"){
                
                $id = self::$connection->getDatabase()->getCounter();
                $newSupplier->setSupplierId($id);
                
                return self::$connection->getDataBase()->insertData(
                    SupplierConverter::convertToStdClass($newSupplier)
                );

            } else {

                $sqlInsert  = "INSERT INTO supplier (";
                $sqlInsert .= "supplierName, contactName, address,";
                $sqlInsert .= " city, country, phone, email, price";
                $sqlInsert .= "VALUES (";
                $sqlInsert .= ":id, :name, :contact, :address, :city,";
                $sqlInsert .= " :country, :phone, :email);";

                self::$connection->getDatabase()->query(
                    $sqlInsert
                );

                $bindData = [
                    ':name' => $newSupplier->getSupplierName(),
                    ':contact' => $newSupplier->getContactName(),
                    ':address' => $newSupplier->getAddress(),
                    ':city' => $newSupplier->getCity(),
                    ':country' => $newSupplier->getCountry(),
                    ':phone' => $newSupplier->getPhone(),
                    ':email' => $newSupplier->getEmail()
                ];

                self::$connection->execute(
                    $bindData
                );
                self::insertProduct($newSupplier);

                return self::$connection->lastInsertedId();
            }
        }

        public static function update(Supplier $newSupplier){

            if( get_class(self::$connection->getDataBase()) == "PDOMongo"){
                return self::$connection->getDataBase()->updateData(
                    SupplierConverter::convertToStdClass($newSupplier)
                );

            } else {

                $sqlUpdate  = "UPDATE supplier SET";
                $sqlUpdate .= " supplierName =:name, contactName =:contact,";
                $sqlUpdate .= " address =:address, city =:city, country =:country";
                $sqlUpdate .= " phone =:phone, email =:email,";
                $sqlUpdate .= " price =:price WHERE supplierId =:id;";

                self::$connection->getDatabase()->query(
                    $sqlUpdate
                );

                $bindData = [
                    ':id' => $newSupplier->getSupplierId(),
                    ':name' => $newSupplier->getSupplierName(),
                    ':contact' => $newSupplier->getContactName(),
                    ':address' => $newSupplier->getAddress(),
                    ':city' => $newSupplier->getCity(),
                    ':country' => $newSupplier->getCountry(),
                    ':phone' => $newSupplier->getPhone(),
                    ':email' => $newSupplier->getEmail()
                ];

                self::$connection->execute(
                    $bindData
                );
                //self::updateProductCascade($newSupplier);
                return self::$connection->lastInsertedId();
            }

        }

        public static function delete(Supplier $newSupplier){

            if( get_class(self::$connection->getDataBase()) == "PDOMongo"){

                return self::$connection->getDataBase()->deleteData(
                    SupplierConverter::convertToStdClass($newSupplier)
                );

            } else {    
                $deleteQuery = "DELETE FROM supplier WHERE supplierId = :id";

                self::$connection->getDatabase()->query(
                    $deleteQuery
                );
               
                self::$connection->getDatabase()->bind(
                    ':id', $newSupplier->getSupplierId()
                );
                
                //self::deleteProductCascade($newSupplier);
                self::$connection->execute();
                return true;
            }
        }

        public static function getSupplier($_id) {

            if( get_class(self::$connection->getDataBase()) == "PDOMongo"){

                self::$connection->getDatabase()->bindElement("supplierId",$_id);
                $newSupplier = SupplierConverter::convertFromStdClass(
                    self::$connection->getDataBase()::findData(
                        [],
                        1
                    )
                );
                return $newSupplier;

            } else {
                $sqlSelect = "SELECT * FROM supplier WHERE supplierId =:id";

                self::$connection->getDatabase()->query($sqlSelect);
                self::$connection->getDatabase()->bind(':id',$_id);
                self::$connection->getDatabase()->execute();

                return self::$connection->singleResult();
            }
                   
        }

        public static function getMultipleSupplier($limit = 0){

            if( get_class(self::$connection->getDataBase()) == "PDOMongo"){

                $supplierArray = SupplierConverter::convertFromStdClass(
                    self::$connection->getDataBase()::findData([],$limit)
                );
    
                return $supplierArray;
            } else {
                $sqlSelectAll = "SELECT * FROM supplier";

                self::$connection->getDatabase()->query(
                    $sqlSelectAll
                );

                self::$connection->getDatabase()->execute();
                return self::$connection->getDatabase()->resultSet();
            }
            
        }

        private static function insertProduct(Supplier $newSupplier){
            $products = $newSupplier->getProducts();

            for($i = 0; $i < count($products); $i++){

                $sqlInsert  = "INSERT INTO productSupplier (";
                $sqlInsert .= " supplierId, productName, unity, price";
                $sqlInsert .= " VALUES (";
                $sqlInsert .= " :id, :name, :unt, :price);";
    
                self::$connection->getDatabase()->query(
                    $sqlInsert
                );
    
                $bindData = [
                    ':id' => $newSupplier->getSupplierId(),
                    ':name' => $products[$i]->getProductName(),
                    ':unt' => $products[$i]->getUnity(),
                    ':price' => $products[$i]->getPrice()
                ];
    
                self::$connection->execute(
                    $bindData
                );
            }
            

        }
/*
        public static function updateProduct(Supplier $supplier){
            
        }
*/
        private static function updateProductCascade(Supplier $newSupplier){
            $products = $newSupplier->getProducts();

            for($i = 0; $i < count($products); $i++){
                $sqlUpdate  = "UPDATE productSupplier SET";
                $sqlUpdate .= " productName =:name, unity =:unt,";
                $sqlUpdate .= " price =:price WHERE productId =:id;";
    
                self::$connection->getDatabase()->query(
                    $sqlUpdate
                );
    
                $bindData = [
                    ':id' => $products[$i]->getProductId(),
                    ':name' => $products[$i]->getProductName(),
                    ':unt' => $products[$i]->getUnity(),
                    ':price' => $products[$i]->getPrice()
                ];
    
                self::$connection->execute(
                    $bindData
                );
            }
            
        }

        private static function deleteProductCascade(Supplier $newSupplier){
            $deleteQuery = "DELETE FROM productSupplier WHERE supplierId = :id";

            self::$connection->getDatabase()->query(
                $deleteQuery
            );
            
            self::$connection->getDatabase()->bind(
                ':id', $newSupplier->getSupplierId()
            );

            self::$connection->execute();
            return true;
        }
    }