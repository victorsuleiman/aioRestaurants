<?php

    class UserCategory{
        private $_id;
        private $categoryId;
        private $categoryName;
        private $notes;

        public function UserCategory($id = 0,$desc,$notes=""){
            $this->categoryId   = $id;
            $this->categoryName = $desc;
            $this->notes        = $notes;
        }

        public function getId(){ return $this->_id; }
        public function getCategoryId(){return $this->categoryId;}
        public function getCategoryName(){return $this->categoryName;}
        public function getNotes(){return $this->notes;}

        public function setId($nId){
            $this->_id = $nId;
        }
        public function setCategoryId($id){
            $this->categoryId = $id;
        }
        public function setCategoryName($name){
            $this->categoryName = $name;
        }
        public function setNotes($notes){
            $this->notes = $notes;
        }
    }