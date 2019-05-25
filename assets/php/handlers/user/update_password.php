<?php

    require_once $_SERVER['HTTP_REFERER'] . '/assets/php/includes/Autoloader.php';

    $DM = new DatabaseManager();

    $_POST = $DM -> sanitize( $_POST );

    if ( isset( $_POST['t'] ) ) {

        $DM -> user_ResetPassword( $_POST['t'], $_POST['password_new'] );

        $DM -> redirect( '/index.php', 'Nové heslo bylo nastaveno', SUCCESS );

    }

    if ( $DM -> user_UpdatePassword( $_POST['id'], $_POST['password_old'], $_POST['password_new'] ) )

        $DM -> redirect( '/assets/php/Administration.php', 'Heslo změněno', SUCCESS );

    else

        $DM -> redirect( '/assets/php/Administration.php', 'Zadali jste špatné heslo', ERROR );

?>