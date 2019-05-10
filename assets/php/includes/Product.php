<?php
    class Product implements JsonSerializable {
        private $id = NULL;
        private $id_category;
        private $id_manufacturer;
        private $name;
        private $description;
        private $color;
        private $toughness;
        private $price;
        private $stock;
        private $pictures;
        private $cnt;

        public function __construct ($id, $id_category, $id_manufacturer, $name, $description, $color, $toughness, $price, $stock, $pictures, $cnt = 0) {
            $this->setId($id);
            $this->setIdCategory($id_category);
            $this->setIdManufacturer($id_manufacturer);
            $this->setName($name);
            $this->setDescription($description);
            $this->setColor($color);
            $this->setToughness($toughness);
            $this->setPrice($price);
            $this->setStock($stock);
            $this->setPictures($pictures);
            $this->setCnt($cnt);
        }

        public function setId               ($id)               { $this->id = $id; }
        public function setIdCategory       ($id_category)      { $this->id_category = $id_category; }
        public function setIdManufacturer   ($id_manufacturer)  { $this->id_manufacturer = $id_manufacturer; }
        public function setName             ($name)             { $this->name = $name; }
        public function setDescription      ($description)      { $this->description = $description; }
        public function setColor            ($color)            { $this->color = $color; }
        public function setToughness        ($toughness)        { $this->toughness = $toughness; }
        public function setPrice            ($price)            { $this->price = $price; }
        public function setStock            ($stock)            { $this->stock = $stock; }
        public function setPictures         ($pictures)         { $this->pictures = $pictures; }
        public function setCnt              ($cnt)              { $this->cnt = $cnt; }

        public function getId               ()                  { return $this->id; }
        public function getIdCategory       ()                  { return $this->id_category; }
        public function getIdManufacturer   ()                  { return $this->id_manufacturer; }
        public function getName             ()                  { return $this->name; }
        public function getDescription      ()                  { return $this->description; }
        public function getColor            ()                  { return $this->color; }
        public function getToughness        ()                  { return $this->toughness; }
        public function getPrice            ()                  { return $this->price; }
        public function getStock            ()                  { return $this->stock; }
        public function getPictures         ()                  { return $this->pictures; }
        public function getCnt              ()                  { return $this->cnt; }
        
        public function jsonSerialize(){
            return [
                'id'                => $this->getId(),
                'id_category'       => $this->getIdCategory(),
                'id_manufacturer'   => $this->getIdManufacturer(),
                'name'              => $this->getName(),
                'description'       => $this->getDescription(),
                'color'             => $this->getColor(),
                'toughness'         => $this->getToughness(),
                'price'             => $this->getPrice(),
                'stock'             => $this->getStock(),
                'pictures'          => $this->getPictures(),
                'cnt'               => $this->getCnt()
            ];
        }
    }
?>