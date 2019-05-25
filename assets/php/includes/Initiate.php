<?php

    require_once 'Autoloader.php';

    $DM = new DatabaseManager();

    if ( isset( $_SESSION['notification'] ) )
        unserialize( $_SESSION['notification'] ) -> display();

    if ( !isset( $_SESSION['shopping-cart'] ) )
        $sc = new ShoppingCart();
    else
        $sc = unserialize( $_SESSION['shopping-cart'] );

?>