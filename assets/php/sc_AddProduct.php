<?php
    include 'includes/config.php';

    if ( !isset($_SESSION['shopping-cart']) )
        $cart = new ShoppingCart();
    else
        $cart = unserialize($_SESSION['shopping-cart']);

    $DM = new DatabaseManager();
    $p = $DM->product_SelectById( $_POST['id'] );

    $cart->addProduct($_POST['id'], $p->getPrice(), $_POST['cnt']);
?>