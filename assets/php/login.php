<?php
    include 'includes/config.php';
    $DM = new DatabaseManager();

    if ( !$DM->user_Login(htmlspecialchars($_POST['login-acc']), htmlspecialchars($_POST['login-pass'])) ) {
//        new Notification('Something went wrong. Please try again.', ERROR);
        header('Location: ' . $_SERVER['DOCUMENT_ROOT'] . '/index.php');
        exit;
    }

    header('Location: ' . $_SERVER['DOCUMENT_ROOT'] . '/loginTest.php');
    exit;
?>