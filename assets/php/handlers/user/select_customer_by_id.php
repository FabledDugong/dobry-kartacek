<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/dobry-kartacek/assets/php/includes/Autoloader.php';

    $DM = new DatabaseManager();

    $_POST = $DM -> sanitize( $_POST, '/index.php' );

    echo json_encode( $DM -> customer_SelectById( $_POST['id'] ) );

?>