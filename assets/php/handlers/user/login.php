<?php

    require_once $_SERVER['HTTP_REFERER'] . '/assets/php/includes/Autoloader.php';

    $DM = new DatabaseManager();

    $_POST = $DM -> sanitize( $_POST, '/index.php' );

    if ( !$DM -> user_Login( $_POST['login'], $_POST['password'] ) )
        $DM -> redirect( '/index.php', 'Příhlášeni se nezdařilo', ERROR );

    $DM -> redirect( '/assets/php/Administration.php' );

?>