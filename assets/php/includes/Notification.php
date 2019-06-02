<?php

    class Notification{

        private $msg;
        private $type;
        private $duration;

        public function __construct ( $msg, $type = '#666', $duration = 3000 ) {

            $this -> msg                = $msg;
            $this -> type               = $type;
            $this -> duration           = $duration;
            $_SESSION['notification']   = serialize( $this );

        }

        public function display () {

            echo '<script> 
                    setTimeout( () => {
                        Notification( "' . $this -> msg . '", "' . $this -> type . '", ' . $this -> duration . ' );
                    }, 10 )
                  </script>';

            unset( $_SESSION['notification'] );

        }

    }

?>