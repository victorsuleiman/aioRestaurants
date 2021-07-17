<?php

    class UserSessionConverter{

        public static function convertFromStdClass($data){
            try{

                if(is_array($data)){
                    $userSessionArray = [];

                    for($i = 0; $i < count($data); $i++){
                        if( get_class($data[$i]) == "stdClass"){
                            array_push(
                                $userSessionArray,
                                self::parseToUserSession($data[$i])
                            );

                        } else {
                            throw new Exception("This is not a valid stdClass! - $i");
                        }
                    }

                    return $userSessionArray;

                } else if(get_class($data) == "stdClass"){
                    return self::parseToUserSession($data);

                } else {
                    throw new Exception("This is not a valid stdClass!");
                }

            } catch(Exception $error){
                echo $error->getMessage();
            }
        }

        /*
        public static function convertToStdClass($data){
            try{

                if(is_array($data)){
                    $userArray = [];

                    for($i = 0; $i < count($data); $i++){
                        if( get_class($data[$i]) == "UserSession" ) {
                            array_push(
                                $userArray,
                                self::parseToStd($data[$i])
                            );

                        } else {
                            throw new Exception("This is not a valid User! - $i");
                        }
                        
                    }
                    return $userArray;

                } else if(get_class($data) == "UserSession"){
                    return self::parseToStd($data);
                    
                } else {
                    throw new Exception("This is not a valid User!");
                }

            } catch(Exception $error){
                echo $error->getMessage();
            }
        }
        */
        /*
        private static function parseToStd(UserSession $userSession) : stdClass{
            $stdClass = new stdClass();

            if( $userSession->getId() != null ) {
                $stdClass->_id = $userSession->getId();
            }
            
            $stdClass->username = $userSession->getUsername();
            $stdClass->password = $userSession->getPassword();
            

            return $stdClass;
        }
        */
        private static function parseToUserSession(stdClass $stdUserSession) : UserSession{

            
            $newUser = new UserSession(
                $stdUserSession->_id,
                $stdUserSession->username,
                $stdUserSession->password
            );
            return $newUser;
        }
    }