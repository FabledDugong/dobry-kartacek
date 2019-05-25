<?php

    require_once $_SERVER['HTTP_REFERER'] . '/assets/php/includes/Autoloader.php';

    $DM = new DatabaseManager();

    $_POST = $DM -> sanitize( $_POST );

    $DM -> product_Delete( $_POST['id'] );

    $DM -> redirect( '/assets/php/Administration.php', 'Produkt smazán', SUCCESS );

?>