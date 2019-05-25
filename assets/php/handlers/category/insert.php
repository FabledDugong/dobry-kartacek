<?php

    require_once $_SERVER['HTTP_REFERER'] . '/assets/php/includes/Autoloader.php';

    $DM = new DatabaseManager();

    $_POST = $DM -> sanitize( $_POST );

    if ( isset( $_POST['id_parent'] ) )
        $DM -> category_Insert( $_POST['name'], $_POST['description'], $_POST['id_parent'] );
    else
        $DM -> category_Insert( $_POST['name'], $_POST['description'] );

    $DM -> redirect( '/assets/php/Administration.php', 'Kategorie přidána', SUCCESS );

?>
