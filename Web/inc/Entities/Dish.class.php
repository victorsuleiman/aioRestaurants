<?php

    class Dish{
        private $_id;
        private $dishId;
        private $dishName;
        private $category;
        private $price;
        private $qty;
        private $ingredients = [];

        public function __construct($name,$price,$nQty){
            $this->dishName = $name;
            $this->price    = $price;
            $this->qty      = $nQty;
        }

        public function getId(){ return $this->_id; }
        public function getDishId(){ return $this->dishId; }
        public function getDishName(){ return $this->dishName; }
        public function getCategory(){ return $this->category; }
        public function getPrice(){ return $this->price; }
        public function getQuantity(){ return $this->qty; }

        public function setId($_id){
            $this->_id = $_id;
        }
        public function setDishId($id){ 
            $this->dishId = $id; 
        }
        public function setDishName($name){ 
            $this->dishName = $name; 
        }
        public function setCategory($category){ 
            $this->category = $category; 
        }
        public function setPrice($price){ 
            $this->price = $price; 
        }
        public function setQuantity($nQty){
            $this->qty = $nQty;
        }

        
        public function getIngredients(){
            return $this->ingredients;
        }
        
        public function setIngredients($ingredients){

            for($i = 0; $i < count($ingredients); $i++){
                array_push($this->ingredients,$ingredients[$i]); 
            }
        }
        
    }