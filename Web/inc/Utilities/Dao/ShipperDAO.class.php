<?php

    class ShipperDAO{
        
        private static $connection;

        public static function startDb($database = "mongo"){
            self::$connection = new Database("Shipper",$database);
        }

        public static function insert(Shipper $newShipper){

            if( get_class(self::$connection->getDataBase()) == "PDOMongo"){
                
                $id = self::$connection->getDatabase()->getCounter();
                $newShipper->setShipperId($id);
                
                return self::$connection->getDataBase()->insertData(
                    ShipperConverter::convertToStdClass($newShipper)
                );

            } else {

                $sqlInsert  = "INSERT INTO shipper (";
                $sqlInsert .= "shipperName, contactName, address,";
                $sqlInsert .= " city, country, phone, email, price";
                $sqlInsert .= "VALUES (";
                $sqlInsert .= ":id, :name, :contact, :address, :city,";
                $sqlInsert .= " :country, :phone, :email, :price);";

                self::$connection->getDatabase()->query(
                    $sqlInsert
                );

                $bindData = [
                    ':name' => $newShipper->getShipperName(),
                    ':contact' => $newShipper->getContactName(),
                    ':address' => $newShipper->getAddress(),
                    ':city' => $newShipper->getCity(),
                    ':country' => $newShipper->getCountry(),
                    ':phone' => $newShipper->getPhone(),
                    ':email' => $newShipper->getEmail(),
                    ':price' => $newShipper->getPrice()
                ];

                self::$connection->execute(
                    $bindData
                );

                return self::$connection->lastInsertedId();
            }
        }

        public static function update(Shipper $newShipper){

            if( get_class(self::$connection->getDataBase()) == "PDOMongo"){
                return self::$connection->getDataBase()->updateData(
                    ShipperConverter::convertToStdClass($newShipper)
                );

            } else {

                $sqlUpdate  = "UPDATE shipper SET";
                $sqlUpdate .= " shipperName =:name, contactName =:contact,";
                $sqlUpdate .= " address =:address, city =:city, country =:country";
                $sqlUpdate .= " phone =:phone, email =:email,";
                $sqlUpdate .= " price =:price WHERE shipperId =:id;";

                self::$connection->getDatabase()->query(
                    $sqlUpdate
                );

                $bindData = [
                    ':id' => $newShipper->getShipperId(),
                    ':name' => $newShipper->getShipperName(),
                    ':contact' => $newShipper->getContactName(),
                    ':address' => $newShipper->getAddress(),
                    ':city' => $newShipper->getCity(),
                    ':country' => $newShipper->getCountry(),
                    ':phone' => $newShipper->getPhone(),
                    ':email' => $newShipper->getEmail(),
                    ':price' => $newShipper->getPrice()
                ];

                self::$connection->execute(
                    $bindData
                );

                return self::$connection->lastInsertedId();
            }

        }

        public static function delete(Shipper $newShipper){

            if( get_class(self::$connection->getDataBase()) == "PDOMongo"){

                return self::$connection->getDataBase()->deleteData(
                    ShipperConverter::convertToStdClass($newShipper)
                );

            } else {    
                $deleteQuery = "DELETE FROM shipper WHERE shipperId = :id";

                self::$connection->getDatabase()->query(
                    $deleteQuery
                );
               
                self::$connection->getDatabase()->bind(
                    ':id', $newShipper->getShipperId()
                );

                self::$connection->execute();
                return true;
            }
        }

        public static function getShipper($_id){

            if( get_class(self::$connection->getDataBase()) == "PDOMongo"){

                self::$connection->getDatabase()->bindElement("shipperId",$_id);
                $newShipper = ShipperConverter::convertFromStdClass(
                    self::$connection->getDataBase()::findData(
                        [],
                        1
                    )
                );
                return $newShipper;

            } else {
                $sqlSelect = "SELECT * FROM shipper WHERE shipperId =:id";

                self::$connection->getDatabase()->query($sqlSelect);
                self::$connection->getDatabase()->bind(':id',$_id);
                self::$connection->getDatabase()->execute();

                return self::$connection->singleResult();
            }
                   
        }

        public static function getMultipleShipper($limit = 0){

            if( get_class(self::$connection->getDataBase()) == "PDOMongo"){

                $shipperArray = ShipperConverter::convertFromStdClass(
                    self::$connection->getDataBase()::findData([],$limit)
                );
    
                return $shipperArray;
            } else {
                $sqlSelectAll = "SELECT * FROM shipper";

                self::$connection->getDatabase()->query(
                    $sqlSelectAll
                );

                self::$connection->getDatabase()->execute();
                return self::$connection->getDatabase()->resultSet();
            }
            
        }
    }