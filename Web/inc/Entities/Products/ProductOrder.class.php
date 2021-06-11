<?php

    require_once("ProductSupplier.class.php");

    class ProductOrder extends ProductSupplier{
        private $quantity;

        public function ProductOrder($id,$name,$un,$price,$qty){
            parent::ProductSupplier($id,$name,$un,$price);
            $this->quantity = $qty;
        }

        public function getQuantity(){
            return $this->quantity;
        }
        public function setQuantity($qty){
            $this->quantity = $qty;
        }

        public function getTotal(){
            return $this->quantity * parent::getPrice();
        }
    }