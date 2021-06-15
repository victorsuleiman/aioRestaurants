<?php


    class Employee{

        private $_id;
        private $employeeId;
        private $firstName;
        private $lastName;
        private $bDate;
        private $address;
        private $city;
        private $postalCode;
        private $phone;
        private $email;
        private $picture;
        private $notes;
        private $userCategory;
        private $username;
        private $password;

        public function __construct(
            $id = 0,
            $fName,
            $lName,
            $nBDate,
            $nAddress,
            $nCity,
            $nPhone,
            $nEmail,
            $nPicture = "",
            $nNotes,
            $nUserCategory,
            $nUsername,
            $nPassword
        ){
            $this->employeeId   = $id;
            $this->firstName    = $fName;
            $this->lastName     = $lName;
            $this->bDate        = $nBDate;
            $this->address      = $nAddress;
            $this->city         = $nCity;
            $this->phone        = $nPhone;
            $this->email        = $nEmail;
            $this->picture      = $nPicture;
            $this->notes        = $nNotes;
            $this->userCategory = $nUserCategory;
            $this->username     = $nUsername;
            $this->password     = $nPassword;
        }

        public function getId(){
            return $this->_id;
        }

        public function getEmployeeId(){
            return $this->employeeId;
        }
        public function getFirstName(){
            return $this->firstName;
        }
        public function getLastName(){
            return $this->lastName;
        }
        public function getBDate(){
            return $this->bDate;
        }
        public function getAddress(){
            return $this->address;
        }
        public function getCity(){
            return $this->city;
        }
        
        public function getPostalCode(){
            return $this->postalCode;
        }
        
        public function getPhone(){
            return $this->phone;
        }
        public function getEmail(){
            return $this->email;
        }
        public function getPicture(){
            return $this->picture;
        }
        public function getNotes(){
            return $this->notes;
        }
        public function getUserCategory(){
            return $this->userCategory;
        }
        public function getUsername(){
            return $this->username;
        }
        public function getPassword(){
            return $this->password;
        }

        public function setId($id){
            $this->_id = $id;
        }
        public function setEmployeeId($id){
            $this->employeeId = $id;
        }
        public function setFirstName($fName){
            $this->firstName = $fName;
        }
        public function setLastName($lName){
            $this->lastName = $lName;
        }
        public function setBDate($birthDate){
            $this->bDate = $birthDate;
        }
        public function setAddress($nAddress){
            $this->address = $nAddress;
        }
        public function setCity($nCity){
            $this->city = $nCity;
        }
        
        public function setPostalCode($nPostalCode){
            $this->postalCode = $nPostalCode;
        }
        
        public function setPhone($nPhone){
            $this->phone = $nPhone;
        }
        public function setEmail($nEmail){
            $this->email = $nEmail;
        }
        public function setPicture($nPicture){
            $this->picture = $nPicture;
        }
        public function setNotes($nNotes){
            $this->notes = $nNotes;
        }
        public function setUserCategory($userCategoryId){
            $this->userCategory = $userCategoryId;
        }
        public function setUsername($username){
            $this->username = $username;
        }
        public function setPassword($password){
            $this->password = $password;
        }


        public function addNotes($newNotes){
            $currentNote  = $this->notes;
            $noteMessage  = "[".date("Y-m-d")." - ".date("h:i:sa")."]";
            $noteMessage .=  "Note added:\n";
            $noteMessage .= $newNotes;
            
            $this->notes  = $noteMessage.$currentNote;
        }

        public function overrideNotes($newNotes){
            $noteMessage  = "[".date("Y-m-d")." - ".date("h:i:sa")."]";
            $noteMessage .=  "Note added:\n";
            $noteMessage .= $newNotes;
            $this->notes = $noteMessage;
        }

    }