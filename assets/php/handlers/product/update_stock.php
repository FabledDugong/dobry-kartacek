<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/dobry-kartacek/assets/php/includes/Autoloader.php';

    $DM = new DatabaseManager();

    $_POST = $DM -> sanitize( $_POST );

    $status = $DM -> product_UpdateStockStatus( $_POST['id'] );

    if ( $status )
        $status = 'Zboží je nyní skladem';
    else
        $status = 'Zboží nyní není skladem';

    $DM -> redirect( '/assets/php/Administration.php', $status, SUCCESS );

?>