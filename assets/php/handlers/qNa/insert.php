<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/dobry-kartacek/assets/php/includes/Autoloader.php';

    $DM = new DatabaseManager();

    $_POST = $DM -> sanitize( $_POST, '/index.php' );

    if ( isset( $_POST['id_question'] ) ){

        $DM -> qNa_InsertAnswer( $_POST['id_question'], $GLOBALS['settings'] -> DEFAULT_EMAIL,$_POST['description'] );

        $DM -> redirect( '/assets/php/Administration.php', 'Odpověď odeslána', SUCCESS );

    } else{

        $DM -> qNa_InsertQuestion( $_POST['email'], $_POST['description'] );

        $DM -> redirect( '/index.php', 'Dotaz odeslán', SUCCESS );

    }

?>
