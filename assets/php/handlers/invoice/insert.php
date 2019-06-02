<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/dobry-kartacek/assets/php/includes/Autoloader.php';

    $DM = new DatabaseManager();

    if ( !isset( $_SESSION['shopping-cart'] ) )
        $DM -> redirect( '/index.php', 'Nákupní košík je prázdný', NOTIFICATION );

    $_POST = $DM -> sanitize( $_POST, '/assets/php/Checkout.php' );

    if ( isset( $_SESSION['user'] ) )

        $user = $DM -> user_SelectById( $_SESSION['user']['id'] );

    else

        $user = new User(
            null,
            $_POST['f_name'],
            $_POST['l_name'],
            $_POST['email'],
            $_POST['phone'],
            $_POST['address'],
            $_POST['city']
        );

    $DM -> invoice_Insert( unserialize( $_SESSION['shopping-cart'] ), $user, $_POST['type_of_delivery'] );

    $DM -> redirect( '/index.php', 'Objednávka proběhla vpořádku', SUCCESS );

?>