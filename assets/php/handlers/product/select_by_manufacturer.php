<?php

    require_once $_SERVER['HTTP_REFERER'] . '/assets/php/includes/Autoloader.php';

    $DM = new DatabaseManager();

    $_POST = $DM -> sanitize( $_POST, '/index.php' );

    echo json_encode( $DM -> product_SelectByManufacturer( $_POST['id_manufacturer'] ) );

?>