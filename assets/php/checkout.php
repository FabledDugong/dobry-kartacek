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

            </div>
            <div id="progress">
                <div class="checkout-phase active">
                    <div>1</div>
                    <div>
                        <a href="">košík</a>
                    </div>
                </div>
                <div class="checkout-phase">
                    <div>2</div>
                    <div>
                        <a href="">doprava a platba</a>
                    </div>
                </div>
                <div class="checkout-phase">
                    <div>3</div>
                    <div>
                        <a href="">dodací údaje</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
<main>
    <section id="cart">
        <div>
            <div id="cart-control">
                <h3>cena</h3>
                <button>pokračovat</button>
            </div>
            <div id="cart-content">
                <ul>
                    <?php
                        foreach ($cart->getProducts() as $product)
                        echo '<li><div class="product-image"></div><div class="product-name">' . 'jmeno a link' . '</div>product id: ' . $product['id'] . '; count: ' . $product['cnt'] . ';<a href="#" class="delete" data-id="' . $product['id'] . '">delete</a></li>';
                    ?>
                </ul
                <?php
                    if (empty($cart->getProducts()))
                        echo "nothing but big emptiness";
                 ?>
            </div>
        </div>
    </section>
</main>
<script type="text/javascript">
    'use strict'

    let _delete = [...document.getElementsByClassName('delete')]
        // _destroy = document.getElementById('destroy')
    // _destroy.addEventListener('click', () => {
    //     const xhr = new XMLHttpRequest()
    //
    //     xhr.onreadystatechange = function () {
    //         if (xhr.readyState === 4 && xhr.status === 200)
    //             console.log('success')
    //     }
    //
    //     xhr.open('GET', 'delShoppingCart.php', true)
    //     xhr.send()
    //
    //     location.reload()
    // })

    _delete.map(el => el.addEventListener('click', () => {
        const xhr = new XMLHttpRequest()

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200)
                console.log('success')
        }

        xhr.open('POST', 'sc_DeleteProduct.php', true)
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')
        xhr.send(`id=${el.dataset.id}`)

        location.reload()
    }))
</script>
</body>
</html>
