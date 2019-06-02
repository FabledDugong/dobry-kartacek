<?php

    class Product {

        public $id;
        public $id_category;
        public $id_manufacturer;
        public $name;
        public $name_category;
        public $name_manufacturer;
        public $description;
        public $color;
        public $toughness;
        public $price;
        public $stock;
        public $pictures;
        public $count;

        public function __construct ( $id, $id_category, $id_manufacturer, $name, $name_category, $name_manufacturer, $description, $color, $toughness, $price, $stock, $pictures = [], $count = 0 ) {

            $this -> id                 = $id;
            $this -> id_category        = $id_category;
            $this -> id_manufacturer    = $id_manufacturer;
            $this -> name               = $name;
            $this -> name_category      = $name_category;
            $this -> name_manufacturer  = $name_manufacturer;
            $this -> description        = $description;
            $this -> color              = $color;
            $this -> toughness          = $toughness;
            $this -> price              = $price;
            $this -> stock              = $stock;
            $this -> pictures           = $pictures;
            $this -> count              = $count;

        }

        public function getSinglePicture () { return $this -> pictures[0]; }

    }

?>