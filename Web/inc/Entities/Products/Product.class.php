<?php

    abstract class Product{
        protected $productId;
        protected $productName;
        protected $unity;

        public function Product($id,$name,$un){
            $this->productId = $id;
            $this->productName = $name;
            $this->unity = $un;
        }

        public function getProductId(){
            return $this->productId;
        }
        /*
        public function setProductId($id){
            $this->productId = $id;
        }
        */

        public function getProductName(){
            return $this->productName;
        }
        public function setProductName($name){
            $this->productName = $name;
        }

        public function getUnity(){
            return $this->unity;
        }
        public function setUnity($un){
            $this->unity = $un;
        }
    }