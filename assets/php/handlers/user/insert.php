<?php

    require_once $_SERVER['HTTP_REFERER'] . '/assets/php/includes/Autoloader.php';

    $DM = new DatabaseManager();

    $_POST = $DM -> sanitize( $_POST, '/index.php' );

    $DM -> user_Insert(
        new User(
            null,
            explode( ' ', $_POST['full_name'] )[0],
            explode( ' ', $_POST['full_name'] )[1],
            $_POST['email'],
            $_POST['phone'],
            $_POST['address'],
            $_POST['city'],
            null,
            $_POST['password']
        )
    );

    $DM -> redirect( '/index.php', 'Prosíme potvrďte registraci pomocí emailu, který jsme Vám zaslali', SUCCESS, 10000 );

?>