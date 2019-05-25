<?php

    require_once $_SERVER['HTTP_REFERER'] . '/assets/php/includes/Autoloader.php';

    $DM = new DatabaseManager();

    $_POST = $DM -> sanitize( $_POST );

    $DM -> manufacturer_Delete( $_POST['id'] );

    $DM -> redirect( '/assets/php/Administration.php', 'Výrobce smazán', SUCCESS );

?>