<?php

    require_once $_SERVER['HTTP_REFERER'] . '/assets/php/includes/Autoloader.php';

    $DM = new DatabaseManager();

    $_POST = $DM -> sanitize( $_POST );

    echo json_encode( $DM -> qNa_SelectByUser( $_POST['email'] ) );

?>