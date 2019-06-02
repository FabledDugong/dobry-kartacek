<?php

    class Log extends Connection {

        private $log;

        public function __construct ( $log ) {

            parent::__construct();

            $this -> log = $log;

            $this -> Insert();

        }

        private function Insert () {

            $this -> exec(

                'INSERT INTO log
                 VALUES(
                    DEFAULT,
                    :log,
                    DEFAULT
                 )',

                [
                    ':log' => $this -> log
                ]

            );

        }

    }

?>