<?php

    class DishConverter{

        public static function convertFromStdClass($data){
            try{

                $dishArray = [];
                if(is_array($data)){

                    for($i = 0; $i < count($data); $i++){

                        if(get_class($data[$i]) == "stdClass"){
                            $dishArray[] = self::parseToDish($data[$i]);
                        } else {
                            throw new Exception("This is not a valid entry Class!");
                        }
                    }

                    return $dishArray;
                } else {
                    if(get_class($data) == "stdClass"){
                        return self::parseToDish($data);
                    } else {
                        throw new Exception("This is not a valid entry Class!");
                    }
                }
            } catch (Exception $errorMessage) {
                echo $errorMessage->getMessage();
            }
        }

        public static function convertToStdClass($data){
            try{
                
                $dishArray = [];
                if(is_array($data)){

                    for($i = 0; $i < count($data); $i++){

                        if(get_class($data[$i]) == "Dish"){
                            $dishArray[] = self::parseToStd($data[$i]);
                        } else {
                            throw new Exception("This is not a valid entry Class!");
                        }
                    }

                    return $dishArray;
                } else {
                    if(get_class($data) == "Dish"){
                        return self::parseToStd($data);
                    } else {
                        throw new Exception("This is not a valid entry Class!");
                    }
                }
            } catch (Exception $errorMessage) {
                echo $errorMessage->getMessage();
            }
        }

        private static function parseToDish(stdClass $dish) : Dish {

            $newDish = new Dish(
                $dish->dishId,
                $dish->name,
                $dish->category,
                $dish->price
            );
            if($dish->_id != null){
                $newDish->setId($dish->_id);
            }

            return $newDish;
        }
        
        private static function parseToStd(Dish $dish) : stdClass {
            $stdClass = new stdClass();
            
            if( $dish->getId() != null ) {
                $stdClass->_id = $dish->getId();
            }

            
            $stdClass->dishId = $dish->getDishId();
            $stdClass->name = $dish->getDishName();
            $stdClass->category = $dish->getCategory();
            $stdClass->price = $dish->getPrice();

            return $stdClass;
        }
    }