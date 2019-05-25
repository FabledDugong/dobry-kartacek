<?php

    require_once $_SERVER['HTTP_REFERER'] . '/assets/php/includes/Autoloader.php';

    $DM = new DatabaseManager();

    $_POST = $DM -> sanitize( $_POST, '/index.php' );

    $DM -> user_ResetPassword( $_POST['token'], $_POST['password_new'] );

    $DM -> redirect( '/index.php', 'Nové heslo bylo nastaveno', ERROR );

?>