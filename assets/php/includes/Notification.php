<?php
    DEFINE('NOTIFICATION', '#007bff');
    DEFINE('SUCCESS', '#28a745');
    DEFINE('ERROR', '#dc3545');

    class Notification{
        private $msg = 'Nothing happened';
        private $type = NOTIFICATION;
        private $duration = 3000;

        public function __construct ($msg, $type, $duration) {
            $this->msg = $msg;
            $this->type = $type;
            $this->duration = $duration;
            $_SESSION['notification'] = $this;
        }

        public function show () {
            $str = "<div class='notification' style='background: {$this->type}'>
                        <h3>{$this->msg}</h3>
                    </div>
                    <script>
                        'use strict'
                        setTimeout(() => {
                          let notification = document.getElementsByClassName('notification')[0]
                          notification.classList.add('visible')
                          
                          setTimeout(() => { notification.classList.remove('visible') }, {$this->duration})
                        }, 100)
                    </script>";

            unset($_SESSION['notification']);
            echo $str;
        }
    }
?>