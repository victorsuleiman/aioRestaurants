<?php
    require_once("Product.class.php");

    class ProductInventory extends Product{
        private $_id;
        private $supplierId;
        private $orderId;
        private $quantity;
        private $sellPrice;
        private $category;
        private $entryDate;
        private $outDate;

        public function ProductInventory(
            $id,$name,$un,
            $supplierId,$qty,$price,$category,
            $inDate
        ){
            parent::Product($id,$name,$un);
            $this->supplierId = $supplierId;
            $this->quantity   = $qty;
            $this->sellPrice  = $price;
            $this->category   = $category;
            $this->entryDate  = $inDate;
        }

        public function getId(){
            return $this->_id;
        }

        public function getOrderId(){
            return $this->orderId;
        }
        public function getSupplierId(){
            return $this->supplierId;
        }
        public function getQuantity(){
            return $this->quantity;
        }
        public function getSellPrice(){
            return $this->sellPrice;
        }
        public function getCategory(){
            return $this->category;
        }
        public function getEntryDate(){
            return $this->entryDate;
        }
        public function getOutDate(){
            return $this->outDate;
        }
        public function getPrice(){
            return $this->sellPrice;
        }

        public function setId($nId){
            $this->_id = $nId;
        }
        
        public function setOrderId($id){
            $this->orderId = $id;
        }
        public function setSupplierId($id){
            $this->supplierId = $id;
        }
        public function setQuantity($qty){
            $this->quantity = $qty;
        }
        public function setSellPrice($price){
            $this->sellPrice = $price;
        }
        public function setCategory($category){
            $this->category = $category;
        }
        public function setEntryDate($dateIn){
            $this->entryDate = $dateIn;
        }
        public function setOutDate($dateOut){
            $this->outDate = $dateOut;
        }
    }