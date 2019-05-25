<?php

    require_once 'FPDF/fpdf.php';

    class Invoice extends FPDF {

        private $sc;
        private $customer;
        private $owner;

        public function __construct( $sc, $customer ){

            parent::__construct();

            $this -> sc         = $sc;
            $this -> customer   = $customer;
            $this -> owner      = json_decode( file_get_contents( $GLOBALS['settings'] -> DOMAIN . '/assets/php/includes/Owner.json' ) );

            $this -> generate();

        }

        private function generate () {

            //            $PDF = new FPDF();
            //            $PDF -> AddPage();
            //            $PDF -> Output( 'D', '../invoices/' . $serial_number . '.pdf' );
            //
            //            $mail = new Mail(  );
            //            $mail -> send_InvoiceMail();

        }

    }

?>