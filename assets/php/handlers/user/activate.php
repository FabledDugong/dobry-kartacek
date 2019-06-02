<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/dobry-kartacek/assets/php/includes/Autoloader.php';

    $DM = new DatabaseManager();

    $_GET = $DM -> sanitize( $_GET, '/index.php' );

    $DM -> user_Activate( $_GET['t'] );

    $DM -> redirect( '/index.php', 'Uživatelský účet aktivován', SUCCESS );

?>