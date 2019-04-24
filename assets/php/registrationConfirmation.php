<?php
    include 'includes/config.php';
    $DM = new DatabaseManager();

    if ( $DM->user_SetActive(htmlspecialchars($_GET['t'])) )
        echo "pohoda";

    header('Location: ../../index.php');
    exit;
?>