<?php

    require_once("PDOMongo.class.php");
    require_once("PDOAgent.class.php");

    class Database{

        private $connection;

        public function __construct($collection,$selectedDb) {
            
            $selectedDb = strtolower($selectedDb);

            if( $selectedDb == "mysql" ){

                try{
    
                    if(!empty($collection)){
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
                        $this->connection = new PDOMongo(
                            strtolower($collection)
                        );
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