<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/dobry-kartacek/assets/php/includes/Autoloader.php';

    $DM = new DatabaseManager();

    $_POST = $DM -> sanitize( $_POST );

    $DM -> user_Delete( $_POST['id'] );

    $DM -> redirect( '/index.php', 'Uživatelský účet smazán', SUCCESS );

?>