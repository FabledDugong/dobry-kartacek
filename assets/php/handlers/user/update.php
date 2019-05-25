<?php

    require_once $_SERVER['HTTP_REFERER'] . '/assets/php/includes/Autoloader.php';

    $DM = new DatabaseManager();

    $_POST = $DM -> sanitize( $_POST, '../Administration.php' );

    $user = $DM -> user_SelectById( $_POST['id'] );

    if ( !isset( $_POST['email'] ) )
        $user -> email = $_POST['email'];

    if ( !isset( $_POST['f_name'] ) )
        $user -> f_name = $_POST['f_name'];

    if ( !isset( $_POST['l_name'] ) )
        $user -> l_name = $_POST['l_name'];

    if ( !isset( $_POST['phone'] ) )
        $user -> phone = $_POST['phone'];

    if ( !isset( $_POST['address'] ) )
        $user -> address = $_POST['address'];

    if ( !isset( $_POST['city'] ) )
        $user -> city = $_POST['city'];

    $DM -> user_Update( $user );

    $DM -> redirect( '/assets/php/Administration.php', 'Údaje změněny', SUCCESS );

?>