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
<!--Heslo musí být alespoň 10 znaků dlouhé. Musí obsahovat alespoň jedno velké písmeno, jednu číslici a jeden symbol.-->
<div id="modal">
    <div id="login">
        <div id="login-control"><img src="assets/img/close.svg" data-role="button-close" alt="close-button" class="icon"></div>
        <h3>přihlásit se</h3>
        <form action="" method="post" name="login-form" id="login-form">
            <input type="email" placeholder="E-mail" id="login-acc" maxlength="30">
            <label for="login-acc">test</label>
            <input type="password" placeholder="Heslo" id="login-pass">
            <label for="login-pass">wrong?</label>
            <input type="submit" value="Přihlásit se" disabled>
        </form>
        <span>Nechcete nakupovat anonymně? <u data-role="link-signup">Registrujte se!</u></span>
    </div>
    <div id="signup">
        <div id="signup-control"><img src="assets/img/close.svg" data-role="button-close" alt="close-button" class="icon"></div>
        <h3>registrovat se</h3>
        <form action="" method="post" name="signup-form" id="signup-form">
            <div>
                <input type="email" placeholder="E-mail" id="signup-acc">
                <label for="signup-acc">test</label>
                <input type="password" placeholder="Heslo" id="signup-pass">
                <label for="signup-pass">wrong?</label>
                <input type="password" placeholder="Potvrzení hesla" id="signup-pass">
                <label for="signup-pass">match?</label>
            </div>
            <div>
                <input type="text" placeholder="Jméno" name="signup-fname" id="signup-fname">
<!--                <label for="signup-fname">Křestn</label>-->
                <input type="text" placeholder="Příjmení" name="signup-sname" id="signup-sname">
                <input type="text" placeholder="Ulice, č. popisné" name="signup-address" id="signup-address">
                <input type="text" placeholder="Město, PSČ" name="signup-address2" id="signup-address2">
                <input type="checkbox" id="consent-personal"><label for="consent-personal">co je do pici</label>
                <input type="submit" value="Potvrdit registraci" disabled>
            </div>
        </form>
        <span>Nejaky hovna o GDPR</span>
    </div>
    <div id="cart"></div>
</div>
<header id="header">
    <div id="intro">
        <div id="control-panel">
            <div id="brand">
                <a><img src="assets/img/scroll.svg" alt="logo" class="logo"></a>
            </div>
            <nav id="menu">
                <a href="#shop">eshop</a>
                <a href="#contact">kontakt</a>
                <a data-role="button-open-login">přihlášení</a>
                <a data-role="button-open-cart">košík</a>
            </nav>
        </div>
        <div>
            <h1>dobrý kartáček</h1>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque eu eleifend nibh, eget sollicitudin
                neque. Morbi sit amet egestas odio.
            </p>
            <div>
                <button>kartáček?</button>
                <button>eshop</button>
            </div>
        </div>
    </div>
    <div class="carousel" id="carousel">
        <div class="images"></div>
        <div class="controls">
            <div class="prev">
                <img src="assets/img/arrow-up.svg" alt="arrow-up">
            </div>
            <div class="next">
                <img src="assets/img/arrow-down.svg" alt="arrow-down">
            </div>
        </div>
        <div class="status"></div>
    </div>
</header>
<main>
    <section id="shop">
        <div id="categories">
            <div class="category">
                <h3>zubní kartáčky</h3>
                <div class="subcategory">
                    <h3>ci medical</h3>
                </div>
                <div class="subcategory">
                    <h3>bio bambusové</h3>
                </div>
            </div>
            <div class="category"><h3>zubní pasty</h3></div>
            <div class="category"><h3>ostatní</h3></div>
        </div>
        <div id="filter">

        </div>
        <div id="products">
            <div class="product" id="product1" data-id="1">
                <div>
                    <h4>product name</h4>
                </div>
            </div>
            <div class="product" id="product2" data-id="2">
                <h4>product name</h4>
            </div>
            <div class="product" id="product3" data-id="3">
                <h4>product name</h4>
            </div>
            <div class="product">
                <h4>product name</h4>
            </div>
        </div>
        <div id="product-detail" data-id="1">
            <div class="product-image"></div>
            <div class="product-content">
                <div class="product-info">
                    <div>
                        <h4>product name</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    </div>
                    <div>
                        <h5>skladem/not</h5>
                        <h5>cena</h5>
                        <h5>typ</h5>
                        <h5>tvrdost</h5>
                        <h5>délka štětin</h5>
                        <h5>barva</h5>
                    </div>
                </div>
                <div class="product-control">
                    <button data-role="button-back">zpět</button>
                    <button data-role="button-buy">koupit</button>
                </div>
            </div>
        </div>
    </section>
    <section id="contact">
        <div>
            <h2>info@dobry-kartacek.cz</h2>
            <h2>+420 123 456 789</h2>
            <address>
                Jilmová 70<br>
                Holubice<br>
                252 65
            </address>
        </div>
        <div id="help">
            <form name="cf" method="post" action="">
                <div>
                    <input type="text" placeholder="Jméno a Příjmení">
                    <input type="email" placeholder="E-mail">
                </div>
                <div>
                    <textarea name="cf-content" placeholder="Vaše zpráva"></textarea>
                    <input type="submit" value="Odeslat" disabled>
                </div>
            </form>
        </div>
    </section>
</main>
<footer id="footer">
    <div id="important">
        <div>
            <h5>důležité odkazy</h5>
            <h6>obchodní podmínky</h6>
            <h6>zpracování osobních údajů</h6>
            <h6>o nás</h6>
            <h6>faq</h6>
        </div>
        <div>
            <h5>jak nakoupit</h5>
            <h6>možnosti dopravy</h6>
            <h6>možnosti platby</h6>
            <h6>reklamace a vrácení</h6>
        </div>
    </div>
    <div id="copy">
        <h6>© 2019 Dobrý kartáček. All rights reserved.</h6>
        <h6>Created by JŠ&MZ</h6>
    </div>
</footer>
<script type="text/javascript" src="assets/js/main.js"></script>
</body>
</html>
