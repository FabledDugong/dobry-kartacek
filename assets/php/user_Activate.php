<?php
    include 'includes/config.php';
    $DM = new DatabaseManager();

    if ( $DM->user_SetActive(htmlspecialchars($_GET['t'])) )
        new Notification('Successfully activated.');
    else
        new Notification('Oops. Something went wrong.');

    header('Location: ../../index.php');
    exit;
?>