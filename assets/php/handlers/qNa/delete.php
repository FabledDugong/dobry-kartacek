<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/dobry-kartacek/assets/php/includes/Autoloader.php';

    $DM = new DatabaseManager();

    $_POST = $DM -> sanitize( $_POST );

    $DM -> qNa_Delete( $_POST['id'] );

    $DM -> redirect( '/assets/php/Administration.php', 'Dotaz/odpověď smazán/a', SUCCESS );

?>