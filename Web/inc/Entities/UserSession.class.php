<?php

    class UserSession{
        private $_id;
        private $username;
        private $password;
        

        public function __construct($nId,$nUsername,$nPassword){
            $this->_id      = $nId;
            $this->username = $nUsername;
            $this->password = $nPassword;
        }

        public function getId(){ return $this->_id; }
        public function getUsername(){return $this->username;}

        public function setId($nId){
            $this->_id = $nId;
        }
        
        public function checkPassword(string $nPassword) : bool {
            $equal = false;
            if(password_verify($nPassword,$this->password)){
                $equal = true;
            }

            return $equal;
        }

    }