<?php
    class Connection {
        const       HOST = 'localhost',
                    NAME = '_dk',
                    USER = 'root',
                    PASS = '';
        protected   $CONN;

        public function __construct () {
            try {
                $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ];
                $this->CONN = new PDO('mysql:host='. self::HOST .';dbname='. self::NAME .';charset=utf8', self::USER, self::PASS, $options);
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        public function checkData ($data = NULL, $returnPath = '../../index.php') {
            $missingData = '';

            if ( empty($data) ) {
                new Notification('There were no input data', ERROR, NULL);
                header('Location: ' . $returnPath);
                exit;
            }

            foreach ($data as $key => $value)
                if(empty($value))
                    $missingData .= $key . '; ';
                else
                    $data[$key] = htmlspecialchars($value);

            if ( !empty($missingData) ) {
                new Notification('It looks like you missed some important data: ' . $missingData, ERROR, 10000);
                header('Location: ' . $returnPath);
                exit;
            }

            return $data;
        }

    }
?>