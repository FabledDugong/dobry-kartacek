<?php
    require_once '../assets/php/includes/config.php';

    if (!isset($_SESSION['shopping-cart']))
        $cart = new ShoppingCart();
    else
        $cart = unserialize($_SESSION['shopping-cart']);

    if ( empty( $cart->getProducts() ) ) {
        new Notification('sry mas prazdnej kosik debile');
        header('Location: ../index.php');
        exit;
    }

    $DM = new DatabaseManager();
    $DM->invoice_Insert( $cart->getProducts(), $cart->getPrice() );
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
    <h2>current invoices</h2>
<?php
    $inv = $DM->invoice_SelectAll();

    foreach ( $inv as $i )
        echo "<div>$i->serial_number $i->date $i->price Kc $i->type_of_delivery zaplaceno? $i->payed $i->f_name $i->l_name $i->email $i->phone $i->address $i->city</div>";

    if ( isset($_SESSION['notification']) )
        unserialize($_SESSION['notification'])->show();
?>
</body>
</html>