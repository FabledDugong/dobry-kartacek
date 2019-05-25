<?php

    class Connection {

        protected $conn;

        public function __construct () {

            $this -> connect();

        }

        protected function connect () {

            try {

                $this -> conn = new PDO (

                    'mysql:host=' . $GLOBALS['settings'] -> DATABASE -> HOST .
                    ';dbname=' . $GLOBALS['settings'] -> DATABASE -> NAME .
                    ';charset=utf8',

                    $GLOBALS['settings'] -> DATABASE -> USER,
                    $GLOBALS['settings'] -> DATABASE -> PASSWORD,

                    [
                        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
                    ]

                );

            } catch ( Exception $e ) {

                die ( 'Error | #' . $e -> getCode() . ' | ' . $e -> getMessage() );

            }

        }

        protected function exec ( $sql, $args ) {

            try {

                $this -> conn -> beginTransaction();

                $query = $this -> conn -> prepare( $sql );
                $query -> execute( $args );

                $this -> conn -> commit();

                if ( preg_match( '/^SELECT/i', $sql )  )
                    return $query -> fetchAll();
                else
                    return true;

            } catch ( Exception $e ) {

                $this -> conn -> rollBack();

                if ( isset( $_SESSION['user'] ) )
                    $this -> redirect( '/assets/php/Administration', 'Error | #' . $e -> getCode() . ' | ' . $e -> getMessage(), ERROR, 10000 );
                else
                    $this -> redirect( '/index', 'Error | #' . $e -> getCode() . ' | ' . $e -> getMessage(), ERROR, 10000 );

            }

        }

        public function sanitize ( $data, $return = '/assets/php/Administration.php' ) {

            $missing = 0;

            foreach ( $data as $key => $val ) {

                if ( empty( $val ) )
                    $missing++;
                else
                    $data[$key] = htmlspecialchars( $val );

            }

            if ( $missing == 0 )
                return $data;
            else
                $this -> redirect( $return, 'Neúplná data', ERROR );

        }

        public function redirect ( $location, $msg = null, $type = '#666', $duration = 3000 ) {

            if ( !empty( $msg ) )
                new Notification( $msg, $type, $duration );

            header( 'Location: ' . $GLOBALS['settings'] -> DOMAIN . $location );
            exit;

        }

        protected function authorize_admin () {

            if ( !isset( $_SESSION['user'] ) || !$_SESSION['user']['admin'] )
                $this -> redirect( '/assets/php/Administration.php', 'Nedostatečné oprávnění', ERROR );

        }

        protected function authorize_user () {

            if ( !isset( $_SESSION['user'] ) )
                $this -> redirect( '/index.php', 'Nejste přihlášeni', ERROR );

        }

    }

?>