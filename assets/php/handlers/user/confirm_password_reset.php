<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/dobry-kartacek/assets/php/includes/Autoloader.php';

    $DM = new DatabaseManager();

    $_GET = $DM -> sanitize( $_GET, '/index.php' );

    if ( !$DM -> user_ConfirmResetPassword( $_GET['t'] ) )

        $DM -> redirect( '/index.php', 'Tento link je již neplatný', ERROR );


?>