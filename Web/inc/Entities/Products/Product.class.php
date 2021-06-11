<?php

    abstract class Product{
        protected $productId;
        protected $productName;
        protected $unit;

        public function Product($id = 0,$name,$un){
            $this->productId = $id;
            $this->productName = $name;
            $this->unit = $un;
        }

        public function getProductId(){
            return $this->productId;
        }
        
        public function setProductId($id){
            $this->productId = $id;
        }
        

        public function getProductName(){
            return $this->productName;
        }
        public function setProductName($name){
            $this->productName = $name;
        }

        public function getUnit(){
            return $this->unit;
        }
        public function setUnit($un){
            $this->unit = $un;
        }
    }