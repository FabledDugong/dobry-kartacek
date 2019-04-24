<?php
    require_once '../assets/php/includes/config.php';

    if ( !isset($_SESSION['shopping-cart']) )
        $cart = new ShoppingCart();
    else
        $cart = unserialize($_SESSION['shopping-cart']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
    <?php
        foreach ( $cart->getProducts() as $product )
            echo 'product id: ' . $product['id'] . '; count: ' . $product['cnt'] . '; <a href="#" class="delete" data-id="' . $product['id'] . '">delete</a><br>';

        if ( empty($cart->getProducts()) )
            echo "nothing but big emptiness";
    ?>
    <br>
    <a href="#" id="destroy">delete whole shopping cart</a>
    <script>
        'use strict'

        let _delete = [...document.getElementsByClassName('delete')],
            _destroy = document.getElementById('destroy')

        _destroy.addEventListener('click', () => {
            const xhr = new XMLHttpRequest()

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200)
                    console.log('success')
            }

            xhr.open('GET', '../assets/php/delShoppingCart.php', true)
            xhr.send()

            location.reload()
        })

        _delete.map(el => el.addEventListener('click', () => {
            const xhr = new XMLHttpRequest()

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200)
                    console.log('success')
            }

            xhr.open('POST', '../assets/php/delFromShoppingCart.php', true)
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')
            xhr.send(`id=${el.dataset.id}`)

            location.reload();
        }))
    </script>
    <?php
        if ( isset($_SESSION['notification']) )
            unserialize($_SESSION['notification'])->show();
    ?>
</body>
</html>