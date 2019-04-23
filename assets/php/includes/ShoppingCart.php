<?php
    class ShoppingCart extends DatabaseManager{
        private $products;
        private $price;

        public function __construct(){
            $this->products = [];
            $this->price = 0;
            $_SESSION['cart'] = $this;
        }

        public function addProduct ($id, $cnt) {
            array_push($this->products, $this->product_SelectById($id));
            $this->products[sizeof($this->products) - 1]->cnt = $cnt;
        }

        public function delProduct ($id) {
            $pos = array_search($this->product_SelectById($id), $this->products);
            array_splice($this->products, $pos, 1);
        }

        public function delShoppingCart () {
            unset($_SESSION['cart']);
        }

        public function getPrice (){
            return $this->price;
        }

        public function getProducts () {
            return $this->products;
        }
    }
?>