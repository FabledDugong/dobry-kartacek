<?php
    include 'includes/config.php';
    $DM = new DatabaseManager();

    $data = [
        'login' => htmlspecialchars($_POST['signup-acc']),
        'password' => htmlspecialchars($_POST['signup-pass']),
        'fName' => explode(' ', htmlspecialchars($_POST['signup-name']))[0],
        'lName' => explode(' ', htmlspecialchars($_POST['signup-name']))[1],
        'phone' => htmlspecialchars($_POST['signup-phone']),
        'address' => htmlspecialchars($_POST['signup-address']),
        'city' => htmlspecialchars($_POST['signup-address2'])
    ];
    $token = $DM->user_Register($data);

    if ( $token == false ) {
        header('Location: ../../index.php');
        exit;
    }

    $mail = new Mail($data['login'], 'no-reply@dobry-kartacek.cz', 'Dobrý Kartáček - potvrzení registrace', $token);

    header('Location: ../../index.php');
    exit;
?>