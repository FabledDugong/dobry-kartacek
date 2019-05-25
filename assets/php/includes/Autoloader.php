<?php

    session_start();

    mb_internal_encoding('UTF-8');

    // temporary for testing on localhost
    $_SERVER['HTTP_REFERER'] = ($_SERVER['DOCUMENT_ROOT'] . '/dobry-kartacek');

    if ( !isset( $GLOBALS['settings'] ) )
        $GLOBALS['settings'] = json_decode( file_get_contents( $_SERVER['HTTP_REFERER'] . '/assets/php/includes/Settings.json' ) );

    spl_autoload_register( function ( $c ) {

        require_once( $_SERVER['HTTP_REFERER'] . '/assets/php/includes/' . $c . '.php' );

    });


?>