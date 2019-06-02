<?php
    include 'includes/config.php';
    $DM = new DatabaseManager();

    if ( !$DM->user_Login(htmlspecialchars($_POST['login-acc']), htmlspecialchars($_POST['login-pass'])) ) {
        new Notification('Přihlášení se nezdařilo.', ERROR);
        header('Location: ../../index.php');
        exit;
    }

    new Notification('Přihlášení proběhlo úspěšně.');
    header('Location: ../../debugging/loginTest.php');
    exit;
?>