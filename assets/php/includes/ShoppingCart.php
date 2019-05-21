<?php
    class ShoppingCart extends DatabaseManager{
        private $products;
        private $price;

        public function __construct(){
            $this->products = [];
            $this->price = 0;
            $_SESSION['shopping-cart'] = serialize($this);
        }

        public function addProduct ( $id, $price, $cnt = 1 ) {
            array_push(
                $this->products,
                [
                    "id"    => $id,
                    "price" => $price,
                    "cnt"   => $cnt
                ]
            );

            $this->price += ( $price * $cnt );

            $_SESSION['shopping-cart'] = serialize($this);
        }

        public function delProduct ( $id ) {
            for ($i = 0; $i < sizeof($this->products); $i++)
                if ( $this->products[$i]['id'] === $id )
                    break;

            $this->price -= ( $this->products[$i]["price"] * $this->products[$i]["cnt"] );

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