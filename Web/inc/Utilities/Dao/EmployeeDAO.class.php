<?php


    class EmployeeDAO {

        private static $connection;

        public static function startDb($dataBase = "mongo"){
            self::$connection = new Database("Employee",$dataBase);
        }

        public static function insert(Employee $newEmployee){
            
            if( get_class(self::$connection->getDataBase()) == "PDOMongo"){

                $id = self::$connection->getDatabase()->getCounter();
                $newEmployee->setEmployeeId($id);

                return self::$connection->getDataBase()->insertData(
                    EmployeeConverter::convertToStdClass($newEmployee)
                );

            } else {
                
                $sqlInsert  = "INSERT INTO employee (";
                $sqlInsert .= "employeeId, firstName, lastName, bDate, address,";
                $sqlInsert .= " city, phone, email, picture, notes, userCategory,";
                $sqlInsert .= " username, password)";
                $sqlInsert .= "VALUES (";
                $sqlInsert .= ":id, :fName, :lName, :bDate, :address, :city,";
                $sqlInsert .= " :phone, :email, :picture, :notes, :userCategory,";
                $sqlInsert .= " :username, :password);";

                self::$connection->getDatabase()->query(
                    $sqlInsert
                );

                $bindData = [
                    ':id' => $newEmployee->getEmployeeId(),
                    ':fName' => $newEmployee->getFirstName(),
                    ':lName' => $newEmployee->getLastName(),
                    ':bDate' => $newEmployee->getBDate(),
                    ':address' => $newEmployee->getAddress(),
                    ':city' => $newEmployee->getCity(),
                    ':phone' => $newEmployee->getPhone(),
                    ':email' => $newEmployee->getEmail(),
                    ':picture' => $newEmployee->getPicture(),
                    ':notes' => $newEmployee->getNotes(),
                    ':userCategory' => $newEmployee->getUserCategory(),
                    ':username' => $newEmployee->getUserCategory(),
                    ':password' => $newEmployee->getPassword()
                ];

                self::$connection->getDatabase()->execute(
                    $bindData
                );

                return self::$connection->lastInsertedId();
            }
            
        }

        public static function update(Employee $newEmployee){

            if( get_class(self::$connection->getDataBase()) == "PDOMongo"){
                return self::$connection->getDataBase()->updateData(
                    EmployeeConverter::convertToStdClass($newEmployee)
                );
                var_dump($newEmployee);

            } else {
                $sqlUpdate  = "UPDATE employee SET";
                $sqlUpdate .= " firstName =:fName, lastName =:lName,";
                $sqlUpdate .= " bDate =:bDate, address =:address,";
                $sqlUpdate .= " city =:city, phone =:phone, email =:email,";
                $sqlUpdate .= " picture =:pic, notes =:notes, userCategory =:category,";
                $sqlUpdate .= " username =:user, password =:pass WHERE";
                $sqlUpdate .= " employeeId =:id;";

                self::$connection->getDatabase()->query(
                    $sqlUpdate
                );

                $bindData = [
                    ':id' => $newEmployee->getEmployeeId(),
                    ':fName' => $newEmployee->getFirstName(),
                    ':lName' => $newEmployee->getLastName(),
                    ':bDate' => $newEmployee->getBDate(),
                    ':address' => $newEmployee->getAddress(),
                    ':city' => $newEmployee->getCity(),
                    ':phone' => $newEmployee->getPhone(),
                    ':email' => $newEmployee->getEmail(),
                    ':pic' => $newEmployee->getPicture(),
                    ':notes' => $newEmployee->getNotes(),
                    ':category' => $newEmployee->getUserCategory(),
                    ':user' => $newEmployee->getUserCategory(),
                    ':pass' => $newEmployee->getPassword()
                ];

                self::$connection->getDatabase()->execute(
                    $bindData
                );

                return self::$connection->getDatabase()->lastInsertedId();
            }
        }

        public static function delete(Employee $newEmployee){
            if( get_class(self::$connection->getDataBase()) == "PDOMongo"){
                return self::$connection->getDataBase()->deleteData(
                    EmployeeConverter::convertToStdClass($newEmployee)
                );

            } else {
                $deleteQuery = "DELETE FROM employee WHERE employeeId = :id";

                self::$connection->getDatabase()->query(
                    $deleteQuery
                );
               
                self::$connection->getDatabase()->bind(
                    ':id', $newEmployee->getEmployeeId()
                );
                self::$connection->getDatabase()->execute();

                return true;
            }
        }

        //It should return an array of Employee. However, with single slot
        public static function getEmployee($_id) {

            if( get_class(self::$connection->getDataBase()) == "PDOMongo"){

                self::$connection->getDatabase()->bindElement("employeeId",$_id);
                
                $newEmployee = EmployeeConverter::convertFromStdClass(
                    self::$connection->getDataBase()::findData(
                        [],
                        1
                    )
                );
                
                return $newEmployee;

            } else {

                $sqlSelect = "SELECT * FROM employee WHERE employeeId =:id";

                self::$connection->getDatabase()->query($sqlSelect);
                self::$connection->getDatabase()->bind(':id',$_id);
                self::$connection->getDatabase()->execute();

                return self::$connection->singleResult();
            }

            
        }

        public static function getMultipleEmployee($limit=0) : Array {
            if( get_class(self::$connection->getDataBase()) == "PDOMongo"){

                $employeeArray = EmployeeConverter::convertFromStdClass(
                    self::$connection->getDataBase()::findData([],$limit)
                );
                
                return $employeeArray;
            } else {
                $sqlSelectAll = "SELECT * FROM employee";

                self::$connection->getDatabase()->query(
                    $sqlSelectAll
                );

                self::$connection->getDatabase()->execute();
                return self::$connection->getDatabase()->resultSet();
            }
            
        }

        //Return a stdClass with ->_id and ->email
        public static function existEmail($email) {

            if( get_class(self::$connection->getDataBase()) == "PDOMongo"){

                self::$connection->getDatabase()->bindElement("email",$email);
                
                return self::$connection->getDatabase()::findData(
                    ["email"],
                    1
                )[0];
            }

        }

        public static function getUser($username) {
            if( get_class(self::$connection->getDataBase()) == "PDOMongo"){

                self::$connection->getDatabase()->bindElement("username",$username);
                
                $newUser = UserSessionConverter::convertFromStdClass(
                    self::$connection->getDataBase()::findData(
                        [],
                        1
                    )[0]
                );
                
                return $newUser;

            } else {

                $sqlSelect = "SELECT * FROM employee WHERE username =:username";

                self::$connection->getDatabase()->query($sqlSelect);
                self::$connection->getDatabase()->bind(':username',$username);
                self::$connection->getDatabase()->execute();

                return self::$connection->singleResult();
            }
        }
    }