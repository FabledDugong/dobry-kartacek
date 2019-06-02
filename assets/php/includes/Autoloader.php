<?php

    session_start();

    mb_internal_encoding('UTF-8');

    // temporary for testing on localhost
    // when deployed change everywhere
    //      require_once $_SERVER['DOCUMENT_ROOT'] . '/dobry-kartacek/assets/php/includes/Autoloader.php';
    // to
    //      require_once $_SERVER['HTTP_REFERER'] . '/assets/php/includes/Autoloader.php';

    $GLOBALS['settings'] = json_decode( file_get_contents( $_SERVER['DOCUMENT_ROOT'] . '/dobry-kartacek/assets/php/includes/Settings.json' ) );

    spl_autoload_register( function ( $c ) {

        require_once( $_SERVER['DOCUMENT_ROOT'] . '/dobry-kartacek/assets/php/includes/' . $c . '.php' );

    });


?>