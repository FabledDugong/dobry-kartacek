<?php

    require_once $_SERVER['HTTP_REFERER'] . '/assets/php/includes/Autoloader.php';

    $DM = new DatabaseManager();

    $DM -> user_Logout();

    $DM -> redirect( '/index.php', 'Byli jste odhlášeni', SUCCESS );

?>