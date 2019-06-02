<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/dobry-kartacek/assets/php/includes/Autoloader.php';

    $DM = new DatabaseManager();

    $_POST = $DM -> sanitize( $_POST );

    if ( isset( $_POST['id_parent'] ) )
        $DM -> category_Update( $_POST['id'], $_POST['name'], $_POST['description'], $_POST['id_parent'] );
    else
        $DM -> category_Update( $_POST['id'], $_POST['name'], $_POST['description'] );

    $DM -> redirect( '/assets/php/Administration.php', 'Kategorie upravena', SUCCESS );

?>
