<?php
    class Mail {
        private $to;
        private $from;
        private $subject;
        private $content;

        public function __construct ($to, $from, $subject, $content) {
            $this->to = $to;
            $this->from = $from;
            $this->subject = $subject;
            $this->content = htmlspecialchars($content);
        }

        public function send_RegistrationMail () {
            $msg =          "<html>
                                <head>
                                    <title>Dobrý Kartáček - potvrzení registrace</title>
                                </head>
                                <body>
                                    <p>Dobrý den,</p>
                                    <p>na našich webových stránkách byl registrován účet s tímto emailem.</p>
                                    <p>Prosíme potvrďte registraci kliknutím na následující link: <a href='https://dobry-kartacek.cz/assets/php/user_Activate.php?t={$this->content}'>Potvrdit registraci</a></p>
                                    <p>Pokud jste se neregistrovali, tento email ignorujte.</p>
                                </body>
                            </html>";
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= "From: " . $this->from;
            mail($this->to, $this->subject, $msg, $headers);
        }
    }
?>