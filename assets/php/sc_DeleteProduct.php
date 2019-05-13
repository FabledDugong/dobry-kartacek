<?php
    require_once 'includes/config.php';

    if ( !isset($_SESSION['shopping-cart']) )
        $cart = new ShoppingCart();
    else
        $cart = unserialize($_SESSION['shopping-cart']);

    $cart->delProduct($_POST['id']);
    new Notification('Product deleted from shopping cart');
?>