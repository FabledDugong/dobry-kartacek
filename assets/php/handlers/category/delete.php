<?php

    require_once $_SERVER['HTTP_REFERER'] . '/assets/php/includes/Autoloader.php';

    $DM = new DatabaseManager();

    $_POST = $DM -> sanitize( $_POST );

    $DM -> category_Delete( $_POST['id'] );

    $DM -> redirect( '/assets/php/Administration.php', 'Kategorie smazána', SUCCESS );

?>