<?php

    require_once $_SERVER['HTTP_REFERER'] . '/assets/php/includes/Autoloader.php';

    $DM = new DatabaseManager();

    $_POST = $DM -> sanitize( $_POST );

    $DM -> invoice_UpdatePayedStatus( $_POST['id'] );

    $DM -> redirect( '/assets/php/Administration.php', 'Objednávka byla označena jako zaplacená', SUCCESS );

?>