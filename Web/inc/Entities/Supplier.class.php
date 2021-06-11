<?php

    //require_once("Products/ProductSupplier.class.php");
    class Supplier{
        //mg, g, Kg, lb, oz, ml, l, can, bottle, jar, tin, glass,  pkg, bag, box, piece, cl
        private $_id;
        private $supplierId;
        private $supplierName;
        private $contactName;
        private $address;
        private $city;
        private $postalCode;
        private $country;
        private $phone;
        private $email;
        private $products = [];

        public function __construct(
            $id = 0,
            $name,
            $contact,
            $nAddress,
            $nCity,
            $nCountry,
            $nPhone,
            $nEmail,
            $nProducts = []
        ){
            $this->supplierId    = $id;
            $this->supplierName  = $name;
            $this->contactName  = $contact;
            $this->address      = $nAddress;
            $this->city         = $nCity;
            $this->country      = $nCountry;
            $this->phone        = $nPhone;
            $this->email        = $nEmail;
            $this->products     = $nProducts;
        }

        public function getId(){
            return $this->_id;
        }

        public function setId($nId){
            $this->_id = $nId;
        }

        public function getSupplierId() {
            return $this->supplierId;
        }

        public function setSupplierId($supplierId) {
            $this->supplierId = $supplierId;
        }

        public function getSupplierName() {
            return $this->supplierName;
        }

        public function setSupplierName($supplierName) {
            $this->supplierName = $supplierName;
        }

        public function getContactName() {
            return $this->contactName;
        }

        public function setContactName($contactName) {
            $this->contactName = $contactName;
        }

        public function getAddress() {
            return $this->address;
        }

        public function setAddress($address) {
            $this->address = $address;
        }

        public function getCity() {
            return $this->city;
        }

        public function setCity($city) {
            $this->city = $city;
        }

        public function getPostalCode() {
            return $this->postalCode;
        }

        public function setPostalCode($postalCode) {
            $this->postalCode = $postalCode;
        }

        public function getCountry() {
            return $this->country;
        }

        public function setCountry($country) {
            $this->country = $country;
        }

        public function getPhone() {
            return $this->phone;
        }

        public function setPhone($phone) {
            $this->phone = $phone;
        }

        public function getEmail() {
            return $this->email;
        }

        public function setEmail($email) {
            $this->email = $email;
        }

        public function getProducts(){
            return $this->products;
        }

        public function setProducts($nProducts){

            try{

                if(is_array($nProducts)){

                    for($i = 0; $i < count($nProducts); $i++){

                        if(get_class($nProducts[$i]) == "ProductSupplier"){
                            array_push($this->products,$nProducts[$i]);
                        } else {
                            throw new Exception(
                                "Product position $i it is not a ProductSupplier object\n"
                            );
                        }
                        
                    }
                } else {
                    array_push($this->products,$nProducts);
                }
                
            } catch(Exception $errorMessage){
                echo $errorMessage->getMessage();
            }
        }
    }