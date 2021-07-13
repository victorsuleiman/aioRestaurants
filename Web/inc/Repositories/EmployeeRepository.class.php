<?php

    class EmployeeRepository{
        private static $employeeCollection = [];

        public static function getEmployeeCollection(){
            return self::$employeeCollection;
        }

        public static function addEmployee(Employee $nEmployee){
            try{
                if(get_class($nEmployee) == "Employee"){
                    array_push(self::$employeeCollection,$nEmployee);
                } else {
                    throw new Exception("This is not an Employee object!");
                }
            } catch(Exception $error){
                echo $error->getMessage();
            }
            
        }

        public static function addAllEmployees($nEmployee){
            try{
                if(!is_array($nEmployee)){
                    throw new Exception("This is not an array!");
                } else {
                    for($i = 0; $i < count($nEmployee); $i++){
                        array_push(self::$employeeCollection,$nEmployee[$i]);
                    }
                }
            } catch(Exception $error) {
                echo $error->getMessage();
            }
        }

        public static function updateEmployee(Employee $nEmployee){
            try{
                if(get_class($nEmployee) == "Employee"){
                    
                    for($i = 0; $i < count(self::$employeeCollection); $i++){
                        if(
                        self::$employeeCollection[$i]->getEmployeeId() == $nEmployee->getEmployeeId()
                        ){
                            self::$employeeCollection[$i] = $nEmployee;
                            break;
                        } else if($i == count(self::$employeeCollection)-1){
                            echo "Id not found!";
                        }
                    }
                } else {
                    throw new Exception("This is not an Employee object!");
                }
            } catch(Exception $error){
                echo $error->getMessage();
            }
        }

        public static function deleteEmployee(int $employeeId){
            try{
                if(is_numeric($employeeId)){
                    for($i = 0; $i < count(self::$employeeCollection); $i++){
                        if(
                            self::$employeeCollection[$i]->getEmployeeId() == $employeeId
                        ){
                            unset(self::$employeeCollection[$i]);
                            break;
                        } else if($i == count(self::$employeeCollection)-1){
                            echo "Id not found!";
                        }
                    }
                } else {
                    throw new Exception("This is not a valid id!");
                }
            } catch(Exception $error){
                echo $error->getMessage();
            }
        }
    }