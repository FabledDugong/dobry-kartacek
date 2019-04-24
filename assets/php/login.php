<?php
    include 'includes/config.php';
    $DM = new DatabaseManager();

    if ( !$DM->user_Login(htmlspecialchars($_POST['login-acc']), htmlspecialchars($_POST['login-pass'])) ) {
        header('Location: ../../index.php');
        exit;
    }

    header('Location: ../../loginTest.php');
    exit;
?>