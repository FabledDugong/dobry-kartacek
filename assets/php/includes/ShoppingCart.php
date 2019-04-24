<?php
    class ShoppingCart extends DatabaseManager{
        private $products;
        private $price;

        public function __construct(){
            $this->products = [];
            $this->price = 0;
            $_SESSION['shopping-cart'] = serialize($this);
        }

        public function addProduct ($id, $cnt = 1) {
            array_push(
                $this->products,
                [
                    "id" => $id,
                    "cnt" => $cnt
                ]
            );

            $_SESSION['shopping-cart'] = serialize($this);
        }

        public function delProduct ($id) {
            for ($i = 0; $i < sizeof($this->products); $i++)
                if ( $this->products[$i]['id'] === $id )
                    break;

            array_splice(
                $this->products,
                $i,
                1
            );

            $_SESSION['shopping-cart'] = serialize($this);
        }

        public function delShoppingCart () {
            unset($_SESSION['shopping-cart']);
        }

        public function getPrice (){
            return $this->price;
        }

        public function getProducts () {
            return $this->products;
        }
    }
?>