<?php

    require_once $_SERVER['HTTP_REFERER'] . '/assets/php/includes/Autoloader.php';

    $DM = new DatabaseManager();

    $_POST = $DM -> sanitize( $_POST );

    $DM -> user_Delete( $_POST['id'] );

    $DM -> redirect( '/index.php', 'Uživatelský účet smazán', SUCCESS );

?>