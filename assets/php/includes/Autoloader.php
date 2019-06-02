<?php

    session_start();

    mb_internal_encoding('UTF-8');

    $GLOBALS['settings'] = json_decode( file_get_contents( $_SERVER['DOCUMENT_ROOT'] . '/dobry-kartacek/assets/php/includes/Settings.json' ) );

    DEFINE( 'NOTIFICATION', $GLOBALS['settings'] -> COLORS -> MAIN );
    DEFINE( 'SUCCESS', $GLOBALS['settings'] -> COLORS -> SUCCESS );
    DEFINE( 'ERROR', $GLOBALS['settings'] -> COLORS -> ERROR );

    spl_autoload_register( function ( $c ) {

        require_once( $_SERVER['DOCUMENT_ROOT'] . '/dobry-kartacek/assets/php/includes/' . $c . '.php' );

    });

?>