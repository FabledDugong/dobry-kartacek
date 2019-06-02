<?php

    class User {

        public $id_customer;
        public $f_name;
        public $l_name;
        public $email;
        public $phone;
        public $address;
        public $city;
        public $id_user;
        public $password;
        public $registration_time;
        public $active;
        public $admin;

        public function __construct ( $id_customer, $f_name, $l_name, $email, $phone, $address, $city, $id_user = null, $password = null, $registration_time = null, $active = null, $admin = null ) {

            $this -> id_customer        = $id_customer;
            $this -> f_name             = $f_name;
            $this -> l_name             = $l_name;
            $this -> email              = $email;
            $this -> phone              = $phone;
            $this -> address            = $address;
            $this -> city               = $city;
            $this -> id_user            = $id_user;
            $this -> password           = $password;
            $this -> registration_time  = $registration_time;
            $this -> active             = $active;
            $this -> admin              = $admin;

        }

    }

?>