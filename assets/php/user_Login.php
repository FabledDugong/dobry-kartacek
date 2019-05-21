<?php
    include 'includes/config.php';
    $DM = new DatabaseManager();

    if ( !$DM->user_Login(htmlspecialchars($_POST['login-acc']), htmlspecialchars($_POST['login-pass'])) ) {
        new Notification('Login unsuccessful.', ERROR);
        header('Location: ../../index.php');
        exit;
    }

    new Notification('Successfully logged in.');
    header('Location: ../../debugging/loginTest.php');
    exit;
?>