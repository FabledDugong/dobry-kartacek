<?php
    DEFINE('NOTIFICATION', '#DE9E33');
    DEFINE('SUCCESS', '#28a745');
    DEFINE('ERROR', '#dc3545');

    class Notification{
        private $msg;
        private $type;
        private $duration;

        public function __construct ($msg, $type = NOTIFICATION, $duration = 3000) {
            $this->msg = $msg;
            $this->type = $type;
            $this->duration = $duration;
            $_SESSION['notification'] = serialize($this);
        }

        public function show () {
            $str = "<div id='notification' style='background: {$this->type}'>
                        <h3>{$this->msg}</h3>
                    </div>
                    <script>
                        (setTimeout(() => {
                            document.getElementById('notification').classList.add('visible')
                            setTimeout(() => { document.getElementById('notification').classList.remove('visible') }, {$this->duration})
                         }, 100) )()
                    </script>";

            unset($_SESSION['notification']);
            echo $str;
        }
    }
?>