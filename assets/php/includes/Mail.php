<?php

    class Mail {

        private $to;
        private $from;
        private $subject;
        private $content;
        private $html;

        public function __construct ( $to, $from, $subject, $content ) {

            $this -> to       = $to;
            $this -> from     = $from;
            $this -> subject  = $subject;
            $this -> content  = $content;
            $this -> html     = "";

        }

        public function send_NewQuestionMail () {

            $this -> html = "<html>
                                <head>
                                    <title>Dobrý Kartáček - nový dotaz</title>
                                </head>
                                <body>
                                    <p>Přišel nový dotaz od <i>{$this -> from}</i></p>
                                    <hr>
                                    <blockquote>{$this -> content}</blockquote>
                                    <hr>
                                    <p><a href='{$GLOBALS['settings'] -> DOMAIN}/assets/php/Administration.php'>Přejít do administrace</a></p>
                                </body>
                            </html>";

            $this -> send();

        }

        public function send_NewAnswerMail ( $answer ) {

            $this -> html = "<html>
                                <head>
                                    <title>Dobrý Kartáček - Váš dotaz byl zodpovězen</title>
                                </head>
                                <body>
                                    <blockquote>
                                        <i>{$this -> content}</i>
                                        <blockquote>{$answer}</blockquote>
                                    </blockquote>
                                    <hr>
                                    <p><a href='{$GLOBALS['settings'] -> DOMAIN}'>Dobrý Kartáček</a></p>
                                </body>
                            </html>";

            $this -> send();

        }

        public function send_RegistrationMail () {

            $this -> html = "<html>
                                <head>
                                    <title>Dobrý Kartáček - potvrzení registrace</title>
                                </head>
                                <body>
                                    <p>Dobrý den,</p>
                                    <p>na našich webových stránkách <a href='{$GLOBALS['settings'] -> DOMAIN}'>www.dobry-kartacek.cz</a> byl registrován účet s touto emailovou adresou.</p>
                                    <p>Prosíme potvrďte registraci kliknutím na následující link: <a href='{$GLOBALS['settings'] -> DOMAIN}/assets/php/handlers/user/activate.php?t={$this -> content}'>Potvrdit registraci</a></p>
                                    <p>Pokud jste se nezaregistrovali Vy, tento email ignorujte.</p>
                                    <hr>
                                    <p><a href='{$GLOBALS['settings'] -> DOMAIN}'>Dobrý Kartáček</a></p>
                                </body>
                            </html>";

            $this -> send();

        }

        public function send_PasswordResetMail () {

            $this -> html = "<html>
                                <head>
                                    <title>Dobrý Kartáček - obnovení hesla</title>
                                </head>
                                <body>
                                    <p>Dobrý den,</p>
                                    <p>na našich webových stránkách <a href='{$GLOBALS['settings'] -> DOMAIN}'>www.dobry-kartacek.cz</a> byl vytvořen dotaz pro obnovu zapomenutého hesla.</p>
                                    <p>Pro nastavení nového hesla kliknětě na následující odkaz: <a href='{$GLOBALS['settings'] -> DOMAIN}/assets/php/Reset_Password.php?t={$this -> content}'>Nastavit nové heslo</a></p>
                                    <p>Pokud jste dotaz nevytvořili Vy, tento email ignorujte.</p>
                                    <hr>
                                    <p><a href='{$GLOBALS['settings'] -> DOMAIN}'>Dobrý Kartáček</a></p>
                                </body>
                            </html>";

            $this -> send();

        }

        public function send_InvoiceMail () {



        }

        private function send () {

            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= "From: " . $this -> from;

            foreach ( $this -> to as $t )
                mail( $t, $this -> subject, $this -> html, $headers );

        }

    }

?>