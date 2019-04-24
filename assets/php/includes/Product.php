<?php
    class Product implements JsonSerializable {
        private $id = NULL;
        private $idCategory;
        private $idManufacturer;
        private $name;
        private $description;
        private $price;
        private $stock;
        private $pictures;
        private $cnt;

        public function __construct ($id, $idCategory, $idManufacturer, $name, $description, $price, $stock, $pictures, $cnt = 0) {
            if ( isset($id) )
                $this->setId($id);

            $this->setIdCategory($idCategory);
            $this->setIdManufacturer($idManufacturer);
            $this->setName($name);
            $this->setDescription($description);
            $this->setPrice($price);
            $this->setStock($stock);
            if ($pictures == null) $pictures = 'missing.svg';
            $this->setPictures($pictures);
            $this->setCnt($cnt);
        }

        public function setId               ($id)               { $this->id = $id; }
        public function setIdCategory       ($idCategory)       { $this->idCategory = $idCategory; }
        public function setIdManufacturer   ($idManufacturer)   { $this->idManufacturer = $idManufacturer; }
        public function setName             ($name)             { $this->name = $name; }
        public function setDescription      ($description)      { $this->description = $description; }
        public function setPrice            ($price)            { $this->price = $price; }
        public function setStock            ($stock)            { $this->stock = $stock; }
        public function setPictures         ($pictures)         { $this->pictures = $pictures; }
        public function setCnt              ($cnt)              { $this->cnt = $cnt; }

        public function getId               ()                  { return $this->id; }
        public function getIdCategory       ()                  { return $this->idCategory; }
        public function getIdManufacturer   ()                  { return $this->idManufacturer; }
        public function getName             ()                  { return $this->name; }
        public function getDescription      ()                  { return $this->description; }
        public function getPrice            ()                  { return $this->price; }
        public function getStock            ()                  { return $this->stock; }
        public function getPictures         ()                  { return $this->pictures; }
        public function getCnt              ()                  { return $this->cnt; }
        
        public function jsonSerialize(){
            return [
                'id' => $this->getId(),
                'id_category' => $this->getIdCategory(),
                'id_manufacturer' => $this->getIdManufacturer(),
                'name' => $this->getName(),
                'decription' => $this->getDescription(),
                'price' => $this->getPrice(),
                'stock' => $this->getStock(),
                'pictures' => $this->getPictures(),
                'cnt' => $this->getCnt()
            ];
        }
    }
?>