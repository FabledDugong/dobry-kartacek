<?php

    DEFINE( 'NOTIFICATION', $GLOBALS['settings'] -> COLORS -> MAIN );
    DEFINE( 'SUCCESS', $GLOBALS['settings'] -> COLORS -> SUCCESS );
    DEFINE( 'ERROR', $GLOBALS['settings'] -> COLORS -> ERROR );

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
                    notification( ' . $this -> msg . ', ' . $this -> type . ', ' . $this -> duration . ' )
                  </script>';

            unset( $_SESSION['notification'] );

        }

    }

?>