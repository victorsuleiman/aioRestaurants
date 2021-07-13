<?php
    require_once("inc/Entities/Products/ProductOrder.class.php");

    class OrderDAO{
        
        private static $connection;

        public static function startDb($database = "mongo"){
            self::$connection = new Database("Order",$database);
        }

        public static function insert(Order $newOrder){

            if( get_class(self::$connection->getDataBase()) == "PDOMongo"){
                
                $id = self::$connection->getDatabase()->getCounter();
                $newOrder->setOrderId($id);
                
                return self::$connection->getDataBase()->insertData(
                    OrderConverter::convertToStdClass($newOrder)
                );

            } else {

                $sqlInsert  = "INSERT INTO order (";
                $sqlInsert .= "supplierId, orderDate, estimateDeliveryDate,";
                $sqlInsert .= " employeeId, shipperId";
                $sqlInsert .= "VALUES (";
                $sqlInsert .= ":id, :date, :delivery, :employee, :shipper);";

                self::$connection->getDatabase()->query(
                    $sqlInsert
                );

                $bindData = [
                    ':id' => $newOrder->getSupplierId(),
                    ':date' => $newOrder->getOrderDate(),
                    ':delivery' => $newOrder->getEstimateDeliveryDate(),
                    ':employee' => $newOrder->getEmployeeId(),
                    ':shipper' => $newOrder->getShipperId()
                ];

                self::$connection->execute(
                    $bindData
                );
                self::insertProduct($newOrder);

                return self::$connection->lastInsertedId();
            }
        }

        public static function update(Order $newOrder){

            if( get_class(self::$connection->getDataBase()) == "PDOMongo"){
                return self::$connection->getDataBase()->updateData(
                    OrderConverter::convertToStdClass($newOrder)
                );

            } else {

                $sqlUpdate  = "UPDATE order SET";
                $sqlUpdate .= " supplierId =:supplier, orderDate =:date,";
                $sqlUpdate .= " estimateDeliveryDate =:delivery,";
                $sqlUpdate .= " employeeId =:employee, shipperId =:shipper,";
                $sqlUpdate .= " WHERE orderId =:id;";

                self::$connection->getDatabase()->query(
                    $sqlUpdate
                );

                $bindData = [
                    ':id' => $newOrder->getOrderId(),
                    ':supplier' => $newOrder->getSupplierId(),
                    ':date' => $newOrder->getOrderDate(),
                    ':delivery' => $newOrder->getEstimateDeliveryDate(),
                    ':employee' => $newOrder->getEmployeeId(),
                    ':shipper' => $newOrder->getShipperId()
                ];

                self::$connection->execute(
                    $bindData
                );
                //self::updateProductCascade($newOrder);
                return self::$connection->lastInsertedId();
            }

        }

        public static function delete(Order $newOrder){

            if( get_class(self::$connection->getDataBase()) == "PDOMongo"){

                return self::$connection->getDataBase()->deleteData(
                    OrderConverter::convertToStdClass($newOrder)
                );

            } else {    
                $deleteQuery = "DELETE FROM order WHERE orderId = :id";

                self::$connection->getDatabase()->query(
                    $deleteQuery
                );
               
                self::$connection->getDatabase()->bind(
                    ':id', $newOrder->getSupplierId()
                );
                
                //self::deleteProductCascade($newSupplier);
                self::$connection->execute();
                return true;
            }
        }

        public static function getOrder($_id) {

            if( get_class(self::$connection->getDataBase()) == "PDOMongo"){

                self::$connection->getDatabase()->bindElement("orderId",$_id);
                $newOrder = OrderConverter::convertFromStdClass(
                    self::$connection->getDataBase()::findData(
                        [],
                        1
                    )
                );
                return $newOrder;

            } else {
                $sqlSelect = "SELECT * FROM order WHERE orderId =:id";

                self::$connection->getDatabase()->query($sqlSelect);
                self::$connection->getDatabase()->bind(':id',$_id);
                self::$connection->getDatabase()->execute();

                return self::$connection->singleResult();
            }
                   
        }

        public static function getMultipleOrders($limit = 0){

            if( get_class(self::$connection->getDataBase()) == "PDOMongo"){

                $orderArray = OrderConverter::convertFromStdClass(
                    self::$connection->getDataBase()::findData([],$limit)
                );
    
                return $orderArray;
            } else {
                $sqlSelectAll = "SELECT * FROM order";

                self::$connection->getDatabase()->query(
                    $sqlSelectAll
                );

                self::$connection->getDatabase()->execute();
                return self::$connection->getDatabase()->resultSet();
            }
            
        }

        private static function insertProduct(Order $newOrder){
            
            $products = $newOrder->getProducts();

            for($i = 0; $i < count($products); $i++){

                $sqlInsert  = "INSERT INTO productOrder (";
                $sqlInsert .= " orderId, productName, unity, price, quantity";
                $sqlInsert .= " VALUES (";
                $sqlInsert .= " :id, :name, :unt, :price, :qty);";
    
                self::$connection->getDatabase()->query(
                    $sqlInsert
                );
    
                $bindData = [
                    ':id' => $newOrder->getOrderId(),
                    ':name' => $products[$i]->getProductName(),
                    ':unt' => $products[$i]->getUnity(),
                    ':price' => $products[$i]->getPrice(),
                    ':qty' => $products[$i]->getQuantity()
                ];
    
                self::$connection->execute(
                    $bindData
                );
            }

        }

        private static function updateProductCascade(Order $newOrder){
            $products = $newOrder->getProducts();

            for($i = 0; $i < count($products); $i++){
                $sqlUpdate  = "UPDATE productOrder SET";
                $sqlUpdate .= " productName =:name, unity =:unt, price =:price";
                $sqlUpdate .= " quantity =:qty WHERE productId =:id;";
    
                self::$connection->getDatabase()->query(
                    $sqlUpdate
                );
    
                $bindData = [
                    ':id' => $products[$i]->getOrderId(),
                    ':name' => $products[$i]->getProductName(),
                    ':unt' => $products[$i]->getUnity(),
                    ':price' => $products[$i]->getPrice(),
                    ':qty' => $products[$i]->getQuantity()
                ];
    
                self::$connection->execute(
                    $bindData
                );
            }
            
        }

        private static function deleteProductCascade(Order $newOrder){
            $deleteQuery = "DELETE FROM productOrder WHERE orderId = :id";

            self::$connection->getDatabase()->query(
                $deleteQuery
            );
            
            self::$connection->getDatabase()->bind(
                ':id', $newOrder->getSupplierId()
            );

            self::$connection->execute();
            return true;
        }
    }