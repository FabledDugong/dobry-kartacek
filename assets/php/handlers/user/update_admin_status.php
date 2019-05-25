<?php

    require_once $_SERVER['HTTP_REFERER'] . '/assets/php/includes/Autoloader.php';

    $DM = new DatabaseManager();

    $_POST = $DM -> sanitize( $_POST );

    $status = $DM -> user_UpdateAdminStatus( $_POST['id'] );

    if ( $status )
        $status = 'Administrátorská práva nastavena';
    else
        $status = 'Administrátorská práva odebrána';

    $DM -> redirect( '/assets/php/Administration.php', $status, SUCCESS );

?>