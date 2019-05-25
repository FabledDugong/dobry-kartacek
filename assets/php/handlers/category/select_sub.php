<?php

    require_once $_SERVER['HTTP_REFERER'] . '/assets/php/includes/Autoloader.php';

    $DM = new DatabaseManager();

    echo json_encode( $DM -> category_SelectSub( $_POST['id_parent'] ) );

?>