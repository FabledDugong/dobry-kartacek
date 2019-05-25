<?php

    require_once $_SERVER['HTTP_REFERER'] . '/assets/php/includes/Autoloader.php';

    $DM = new DatabaseManager();

    $_POST = $DM -> sanitize( $_POST, '/index.php' );

    if ( !$DM -> user_RequestResetPassword( $_POST['email'] ) )

        $DM -> redirect( '/index.php', 'Daný účet neexistuje', SUCCESS );

    $DM -> redirect( '/index.php', 'Na daný email jsme Vám zaslali odkaz pro obnovu hesla', SUCCESS );

?>