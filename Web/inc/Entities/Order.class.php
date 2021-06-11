<?php

    require_once("Products/ProductOrder.class.php");
    class Order{
        private $_id;
        private $orderId;
        private $supplierId;
        private $orderDate;
        private $estimateDeliveryDate;
        private $employeeId;
        private $shipperId;
        private $products = [];

        public function __construct(
            $id = 0,
            $supId,
            $date,
            $deliveryDate,
            $empId,
            $shipId,
            $nProducts = []
        ){
            $this->orderId              = $id;
            $this->supplierId           = $supId;
            $this->orderDate            = $date;
            $this->estimateDeliveryDate = $deliveryDate;
            $this->employeeId           = $empId;
            $this->shipperId            = $shipId;
            $this->products             = $nProducts;
        }

        public function getId(){ return $this->_id; }

        public function getOrderId(){ return $this->orderId; }
        public function getSupplierId(){ return $this->supplierId;}
        public function getOrderDate(){ return $this->orderDate;}
        public function getEstimateDeliveryDate(){ return $this->estimateDeliveryDate;}
        public function getEmployeeId(){ return $this->employeeId;}
        public function getShipperId(){ return $this->shipperId;}

        public function setId($nId){
            $this->_id = $nId;
        }

        public function setOrderId($id){ 
            $this->orderId = $id;
        }
        public function setSupplierId($suppId){
            $this->supplierId = $suppId;
        }
        public function setOrderDate($orderDate){
            $this->orderDate = $orderDate;
        }
        public function setEstimateDeliveryDate($deliveryDate){
            $this->estimateDeliveryDate = $deliveryDate;
        }
        public function setEmployeeId($empId){
            $this->employeeId = $empId;
        }
        public function setShipperId($shipId){
            $this->shipperId = $shipId;
        }

        public function setProducts($nProducts){

            try{

                if(is_array($nProducts)){

                    for($i = 0; $i < count($nProducts); $i++){
    
                        if(get_class($nProducts[$i]) == "ProductOrder"){
                            array_push($this->products,$nProducts[$i]);
                        } else {
                            throw new Exception(
                                "Product position $i it is not a ProductOrder object\n"
                            );
                        }
                        
                    }
                } else {
                    array_push($this->products,$nProducts);
                }
            } catch(Exception $errorMessage) {
                echo $errorMessage->getMessage();
            }
        }

        public function getProducts(){
            return $this->products;
        }

        public function getTotalOrder(){

            $total = 0;
            
            for($i = 0; $i < count($this->products); $i++){
                $total += $this->products[$i]->getPrice() * $this->products[$i]->getQuantity();
            }

            return $total;
        }
    }