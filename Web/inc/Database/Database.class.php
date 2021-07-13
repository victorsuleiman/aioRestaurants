<?php

    class Database{

        private $connection;

        public function __construct($collection,$selectedDb) {
            
            $selectedDb = strtolower($selectedDb);

            if( $selectedDb == "mysql" ){

                try{
    
                    if(!empty($collection)){
                        require_once("PDOAgent.class.php");
                        $this->connection = new PDOAgent($collection);
                    } else {
                        throw new Exception("Please, select a class to work with!");
                    }

                } catch (Exception $errorMessage){
                    echo $errorMessage->getMessage();
                }

            } else {

                try{

                    if(!empty($collection)){
                        require_once("PDOMongo.class.php");
                        
                        if($collection == "ProductInventory"){
                            $collection = "productInventory";
                            $this->connection = new PDOMongo(
                                $collection
                            );
                        } else if($collection == "UserCategory"){
                            $collection = "userCategory";
                            $this->connection = new PDOMongo(
                                $collection
                            );                   
                        } else {
                            $this->connection = new PDOMongo(
                                strtolower($collection)
                            );
                        }
                        
                    } else {
                        throw new Exception("Please, set a collection to work with!");
                    }
                   
                } catch (Exception $errorMessage){
                    echo $errorMessage->getMessage();
                }
            }
            
        }

        public function getDataBase(){
            return $this->connection;
        }
    }