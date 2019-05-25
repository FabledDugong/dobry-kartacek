<?php

    class ShoppingCart extends Connection {

        public $products;
        public $price;

        public function __construct () {

            $this -> products   = [];
            $this -> price      = 0;

            $_SESSION['shopping-cart'] = serialize( $this );

        }

        public function AddProduct ( $id, $count = 1 ) {

            array_push(

                $this -> products,

                [
                    'id'    => $id,
                    'count' => $count
                ]

            );

            $this -> connect();

            $query = $this -> exec(

                'SELECT price 
                 FROM product 
                 WHERE id = :id',

                [
                    ':id' => $id
                ]

            );

            $this -> conn = null;

            $this -> price += ( $query[0] -> price * $count );

            $_SESSION['shopping-cart'] = serialize( $this );

        }

        public function DeleteProduct ( $id ) {

            for ( $i = 0; $i < sizeof( $this->products ); $i++ )
                if ( $this -> products[$i]['id'] === $id )
                    break;

            $this -> connect();

            $query = $this -> exec(

                'SELECT price 
                 FROM product 
                 WHERE id = :id',

                [
                    ':id' => $id
                ]

            );

            $this -> conn = null;

            $this -> price -= ( $query[0] -> price * $this -> products[$i]['count'] );

            unset( $this -> products[$i] );

            $_SESSION['shopping-cart'] = serialize( $this );

        }

        public function Delete () {

            unset( $_SESSION['shopping-cart'] );

        }

    }

?>