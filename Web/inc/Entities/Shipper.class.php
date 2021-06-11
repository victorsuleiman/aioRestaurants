<?php

    class Shipper{
        private $_id;
        private $shipperId;
        private $shipperName;
        private $contactName;
        private $address;
        private $city;
        private $postalCode;
        private $country;
        private $phone;
        private $email;
        private $price;

        public function __construct(
            $id = 0,
            $name,
            $contact,
            $nAddress,
            $nCity,
            $nCountry,
            $nPhone,
            $nEmail,
            $nPrice
        ){
            $this->shipperId    = $id;
            $this->shipperName  = $name;
            $this->contactName  = $contact;
            $this->address      = $nAddress;
            $this->city         = $nCity;
            $this->country      = $nCountry;
            $this->phone        = $nPhone;
            $this->email        = $nEmail;
            $this->price        = $nPrice;
        }

        public function getId(){
            return $this->_id;
        }

        public function setId($nId){
            $this->_id = $nId;
        }

        public function getShipperId() {
            return $this->shipperId;
        }

        public function setShipperId($shipperId) {
            $this->shipperId = $shipperId;
        }

        public function getShipperName() {
            return $this->shipperName;
        }

        public function setShipperName($shipperName) {
            $this->shipperName = $shipperName;
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

        public function getPrice(){
            return $this->price;
        }
        public function setPrice($nPrice){
            $this->price = $nPrice;
        }
    }