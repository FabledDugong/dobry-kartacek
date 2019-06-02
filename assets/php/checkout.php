<?php
include 'includes/config.php';

if (!isset($_SESSION['shopping-cart']))
    $cart = new ShoppingCart();
else
    $cart = unserialize($_SESSION['shopping-cart']);
?>
<!doctype html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="../css/control.css">
</head>
<body>
<header>
    <nav id="navigation">
        <div>
            <div id="brand">
                <a><img src="../img/dk_logo.svg" alt="logo" class="logo"></a>
            </div>

        </div>
    </nav>
</header>
<main>
    <section id="checkout">
        <div>
            <div id="checkout-control">
                <div class="tab active" data-target="sc">košík</div>
                <div class="tab" data-target="tp">doprava a platba</div>
                <div class="tab" data-target="dt">dodací údaje</div>
                <div class="tab" data-target="sm">shrnutí</div>
            </div>
            <div id="checkout-content">
                <div class="tab-content" id="sc">
                    <ul>
                        <?php
                        foreach ($cart->getProducts() as $product)
                            echo '<li><div class="product-image"></div><div class="product-name">' . 'jmeno a link' . '</div>product id: ' . $product['id'] . '; count: ' . $product['cnt'] . ';<a href="#" class="delete" data-id="' . $product['id'] . '">delete</a></li>';

                        $cart->getPrice()
                        ?>
                    </ul>
                </div>
                <div class="tab-content" id="tp">
                    <div>
                        <h2>doprava</h2>
                        <label for="ceska_posta_1">Česká pošta - balík do ruky</label>
                        <input type="checkbox" name="ceska_posta_1" class="transport">
                        <label for="ceska_posta_2">Česká pošta - balík na poštu</label>
                        <input type="checkbox" name="ceska_posta_2" class="transport">
                    </div>
                    <div>
                        <h2>platba</h2>
                        <label for="cod">dobírkou</label>
                        <input type="checkbox" name="cod" class="payment">
                        <label for="bt">předem - převodem na bankovní účet</label>
                        <input type="checkbox" name="bt" class="payment">
                    </div>
                </div>
                <div class="tab-content" id="dt">

                </div>
                <div class="tab-content" id="sm">

                </div>
            </div>
        </div>
    </section>

    <!--    <section id="cart">-->
    <!--        <div>-->
    <!--            <div id="cart-control">-->
    <!--                <h3>--><?php //$cart->getPrice() ?><!--</h3>-->
    <!--                <button>pokračovat</button>-->
    <!--            </div>-->
    <!--            <div id="cart-content" class="tab active">-->
    <!--                <ul>-->
    <!--                    --><?php
    //                        foreach ($cart->getProducts() as $product)
    //                            echo '<li><div class="product-image"></div><div class="product-name">' . 'jmeno a link' . '</div>product id: ' . $product['id'] . '; count: ' . $product['cnt'] . ';<a href="#" class="delete" data-id="' . $product['id'] . '">delete</a></li>';
    //
    //                        $cart->getPrice()
    //                        ?>
    <!--                </ul-->
    <!--                --><?php
    //                    if (empty($cart->getProducts()))
    //                        echo "nothing but big emptiness";
    //                 ?>
    <!--            </div>-->
    <!--            <div id="cart-content" class="tab">-->
    <!--                <ul>-->
    <!--                    --><?php
    //                    foreach ($cart->getProducts() as $product)
    //                        echo '<li><div class="product-image"></div><div class="product-name">' . 'jmeno a link' . '</div>product id: ' . $product['id'] . '; count: ' . $product['cnt'] . ';<a href="#" class="delete" data-id="' . $product['id'] . '">delete</a></li>';
    //                    ?>
    <!--                </ul-->
    <!--                --><?php
    //                if (empty($cart->getProducts()))
    //                    echo "nothing but big emptiness";
    //                ?>
    <!--            </div>-->
    <!--            <div id="cart-content" class="tab">-->
    <!--                <ul>-->
    <!--                    --><?php
    //                    foreach ($cart->getProducts() as $product)
    //                        echo '<li><div class="product-image"></div><div class="product-name">' . 'jmeno a link' . '</div>product id: ' . $product['id'] . '; count: ' . $product['cnt'] . ';<a href="#" class="delete" data-id="' . $product['id'] . '">delete</a></li>';
    //                    ?>
    <!--                </ul-->
    <!--                --><?php
    //                if (empty($cart->getProducts()))
    //                    echo "nothing but big emptiness";
    //                ?>
    <!--            </div>-->
    <!--        </div>-->
    <!--    </section>-->
</main>
<script type="text/javascript" src="../js/checkout.js"></script>
</body>
</html>
