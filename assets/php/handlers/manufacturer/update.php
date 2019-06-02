<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/dobry-kartacek/assets/php/includes/Autoloader.php';

    $DM = new DatabaseManager();

    $_POST = $DM -> sanitize( $_POST );

    $DM -> manufacturer_Update( $_POST['id'], $_POST['name'], $_POST['description'] );

    $DM -> redirect( '/assets/php/Administration.php', 'Výrobce upraven', SUCCESS );

?>