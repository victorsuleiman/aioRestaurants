<?php
    require_once("Product.class.php");
    
    class ProductSupplier extends Product{
        protected $price;

        public function ProductSupplier($id,$name,$unit,$price){
            parent::Product($id,$name,$unit);
            $this->price = $price;
        }

        public function getPrice(){
            return $this->price;
        }
        public function setPrice($nPrice){
            $this->price = $nPrice;
        }
    }