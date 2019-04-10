<?php

?>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">
</head>
<body>
<header id="header">
    <div id="intro">
        <div id="control-panel">
            <div id="brand">
                <a><img src="" alt="logo" class="logo"></a>
            </div>
            <div>
                <a href="#">přihlášení</a>
                <a href="#">košík</a>
            </div>

<!--            <a><img src="assets/img/shopping-cart.svg" alt="shopping-cart" class="icon"></a>-->
        </div>
        <div>
            <h1>dobrý kartáček</h1>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque eu eleifend nibh, eget sollicitudin neque. Morbi sit amet egestas odio.
            </p>
            <a href="#"><img src="assets/img/scroll.svg" alt="scroll" class="icon"></a>
        </div>
    </div>
    <div class="carousel" id="carousel">
        <div class="images"></div>
        <div class="controls">
            <div class="prev">
                <svg width="24" height="24" viewBox="0 0 24 24">
                    <path d="M20,11V13H8L13.5,18.5L12.08,19.92L4.16,12L12.08,4.08L13.5,5.5L8,11H20Z"></path>
                </svg>
            </div>
            <div class="next">
                <svg width="24" height="24" viewBox="0 0 24 24">
                    <path d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z"></path>
                </svg>
            </div>
        </div>
        <div class="status"></div>
    </div>
</header>
<main>
    <section id="why">
        <div class="why-division">
            <img src="assets/img/scroll.svg" alt="icon" class="icon">
            <h3>nejlepší výběr</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        </div>
        <div class="why-division">
            <img src="assets/img/scroll.svg" alt="icon" class="icon">
            <h3>nejlepší výběr</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        </div>
        <div class="why-division">
            <img src="assets/img/scroll.svg" alt="icon" class="icon">
            <h3>nejlepší výběr</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        </div>
    </section>
    <section id="shop">
        <div id="categories">
            <div class="category">
                <h3>category 1</h3>
                <div class="subcategory">
                    <h3>subcategory 1.1</h3>
                </div>
                <div class="subcategory">
                    <h3>subcategory 1.2</h3>
                </div>
            </div>
            <div class="category"><h3>category 2</h3></div>
            <div class="category"><h3>category 3</h3></div>
            <div class="category"><h3>category 4</h3></div>
        </div>
        <div id="filter">

        </div>
        <div id="products">
            <div class="product" id="product1">
                <h4>product name</h4>
            </div>
            <div class="product" id="product2">
                <h4>product name</h4>
            </div>
            <div class="product" id="product3">
                <h4>product name</h4>
            </div>
            <div class="product">
                <h4>product name</h4>
            </div>
        </div>
    </section>
</main>
<footer id="footer">
    <div class="section-content" id="contact">
        <h2>info@dobry-kartacek.cz</h2>
        <h2>+420 123 456 789</h2>
        <address>
            Antonova 17,
            Pardubice
            53002
        </address>
        <div id="contact-form">
            <form name="cf" method="post" action="">
                <input type="text">
                <input type="email">
                <textarea name="cf-content" placeholder="test"></textarea>
                <input type="submit" disabled>
            </form>
        </div>
    </div>
    <div class="section-content" id="important">
    <div id="copy">
        <h6>© 2019 Dobrý kartáček. All rights reserved.</h6>
        <h6>Created by JŠ&MZ</h6>
    </div>
</footer>
<script type="text/javascript" src="assets/js/main.js"></script>
</body>
</html>
