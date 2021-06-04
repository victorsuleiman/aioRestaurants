<?php

    class EmployeeReport{

        private static $employeeArray;

        public static function getEmployees(){
            $cursor = new Database("employee");

            self::$employeeArray = EmployeeConverter::convertFromStdClass($cursor->getDataBase()->findData(
                [],
                5,
                "employeeId"
            ));

            return self::$employeeArray;
        }
    }