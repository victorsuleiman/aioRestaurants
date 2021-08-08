<?php

    class Receipt{
        
        private $_id;
        private $server;
        private $employeeId;
        private $dishes = [];
        private $taxes;
        private $total;
        private $paymentType;
        private $date;

        public function __construct($server,$employee,$taxes,$total,$payment,$date) {
            $this->server      = $server;
            $this->employeeId  = $employee;
            $this->taxes       = $taxes;
            $this->total       = $total;
            $this->paymentType = $payment;
            $this->date        = $date;
        }

        public function getId(){
            return $this->_id;
        }
        public function setId($id){
            $this->_id = $id;
        }

        public function getServer(){ return $this->server; }
        public function getEmployeeId(){return $this->employeeId; }
        public function getTaxes(){return $this->taxes; }
        public function getTotal(){return $this->total; }
        public function getPaymentType(){return $this->paymentType; }
        public function getDate(){return $this->date; }

        public function setReceiptId($id){
            $this->receiptId = $id;
        }

        public function setServer($nServer){ 
            $this->server = $nServer;
        }
        public function setEmployeeId($nEmployee){
            $this->employeeId = $nEmployee;
        }
        public function setTaxes($nTaxes){
            $this->taxes = $nTaxes;
        }
        public function setTotal($nTotal){
            $this->total = $nTotal;
        }
        public function setPaymentType($payment){
            $this->paymentType = $payment;
        }
        public function setDate($date){
            $this->date = $date;
        }

        public function getDishes(){
            return $this->dishes;
        }

        public function setDishes($nDishes){
            
            for($i = 0; $i < count($nDishes); $i++){
                array_push($this->dishes,$nDishes[$i]);
            }
        }

    }