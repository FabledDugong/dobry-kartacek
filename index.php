<?php

    require_once 'assets/php/includes/Initiate.php';

    $products = $DM -> product_SelectAll();
    $categories = $DM -> category_SelectMain();

?>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dobrý kartáček</title>
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">
</head>
<body>
<!--Heslo musí být alespoň 10 znaků dlouhé. Musí obsahovat alespoň jedno velké písmeno, jednu číslici a jeden symbol.-->
<div id="modal">
    <div id="login">
        <div id="login-control"><img src="assets/img/close.svg" data-role="button-modal-close" alt="close-button"
                                     class="icon"></div>
        <h3>přihlásit se</h3>
        <form action="assets/php/handlers/user/login.php" method="post" name="login-form" id="login-form">
            <input type="text" placeholder="E-mail" name="login" id="login-acc" maxlength="30">
            <label for="login-acc">test</label>
            <input type="password" placeholder="Heslo" name="password" id="login-pass">
            <label for="login-pass">wrong?</label>
            <input type="submit" value="Přihlásit se">
        </form>
        <span>Nechcete nakupovat anonymně? <u data-role="link-signup">Registrujte se!</u></span>
    </div>
    <div id="signup">
        <div id="signup-control">
            <img src="assets/img/close.svg" data-role="button-modal-close" alt="close-button" class="icon">
        </div>
        <h3>registrovat se</h3>
        <form action="assets/php/handlers/user/insert.php" method="post" name="signup-form" id="signup-form">
            <div>
                <input type="email" placeholder="E-mail" name="email" id="signup-acc">
                <label for="signup-acc">test</label>
                <input type="password" placeholder="Heslo" name="password" id="signup-pass">
                <label for="signup-pass">wrong?</label>
                <input type="password" placeholder="Potvrzení hesla" id="signup-pass2">
                <label for="signup-pass">match?</label>
            </div>
            <div>
                <!--                <label for="signup-fname">Křestn</label>-->
                <input type="text" placeholder="Jméno a příjmení" name="full_name" id="signup-name">
                <input type="text" placeholder="Ulice, č. popisné" name="address" id="signup-address">
                <input type="text" placeholder="Město, PSČ" name="city" id="signup-address2">
                <input type="text" placeholder="Telefonní číslo" name="phone" id="signup-phone">
                <input type="checkbox" id="consent-personal"><label for="consent-personal">co je do pici</label>
                <input type="submit" value="Potvrdit registraci">
            </div>
        </form>
        <span>Nejaky hovna o GDPR</span>
    </div>
</div>
<header id="header">
    <div id="intro">
        <nav id="navigation">
            <div id="brand">
                <a><img src="assets/img/dk_logo.svg" alt="logo" class="logo"></a>
            </div>
            <div id="menu">
                <a href="#shop">obchod</a>
                <a href="#contact">kontakt-poradna</a>
                <?php
                    if ( !isset( $_SESSION['user'] ) )
                        echo '<a data-role="button-open-login">přihlášení</a>';
                    else if ( $_SESSION['user']['admin'] )
                        echo '<a href="#">administrace</a>';
                ?>
                <a href="assets/php/checkout.php" data-role="button-open-cart" id="ct">košík</a>
            </div>
        </nav>
        <div>
            <div>
                <h1>DOBRÝ KARTÁČEK</h1>
                <p>
                    je základem každého dobrého úsměvu.
                </p>
            </div>
            <div>
                <img src="assets/img/dk_logo_full.svg" alt="logo_full" class="logo_full">
            </div>
            <div>
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
            <?php
                foreach ( $categories as $c ) {
                    $subs = $DM -> category_SelectSub( $c -> id );

                    echo "<div class='category' data-id='{$c -> id}'>
                                <div><h3>{$c -> name}</h3></div>";

                    foreach ( $subs as $s )
                        echo "<div class='subcategory' data-id='{$s -> id}'>
                                <h3>{$s -> name}</h3>
                              </div>";

                    echo "</div>";
                }
            ?>
        </div>
        <div id="products">
            <?php
                foreach ( $products as $p )
                    echo
                    "<div class='product' id='product{$p -> id}' data-id='{$p -> id}' style='background: url(\"assets/img/products/{$p -> pictures}\") no-repeat center center / contain'>
                    <div>
                        <h4>{$p -> name}</h4>
                        <p>{$p -> price}Kč</p>
                    </div>
                </div>";
            ?>
        </div>
        <div id="product-detail" data-id="null">
            <div>
                <div class="product-image"></div>
            </div>
            <div>
                <div class="product-info"></div>
                <div class="product-control">
                    <div>
                        <div>
                            <input type="number" value="1" name="cnt" id="cnt">
                            <label for="cnt">počet kusů</label>
                        </div>
                    </div>
                    <div>
                        <button data-role="button-back">zpět</button>
                        <button data-role="button-buy">do košíku</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="contact">
        <div>
            <div id="contact-info">
                <h2>info@dobrykartacek.cz</h2>
                <h2>+420 606 819 238</h2>
                <address>
                    <ul>
                        <li>Tomáš Benák</li>
                        <li>Jilmová 70</li>
                        <li>Holubice</li>
                        <li>252 65</li>
                    </ul>
                </address>
            </div>
            <div id="help">
                <div id="help-control">
                    <h3>Poradna</h3>
                    <p>
                        Chcete udělat správné rozhodnutí pro své zuby, ale nejste si jistí výběrem kartáčku?
                        Napište nám a my Vám pomůžeme!
                    </p>
                </div>
                <form name="cf" method="post" action="">
                    <div>
                        <input type="text" placeholder="Jméno a Příjmení">
                        <input type="email" placeholder="E-mail">
                    </div>
                    <div>
                        <textarea name="cf-content" placeholder="Vaše zpráva" maxlength="500"></textarea>
                    </div>
                    <input type="submit" value="Odeslat">
                </form>
            </div>
        </div>
        <div>
            <div id="important">
                <div>
                    <h3>důležité odkazy</h3>
                    <ul>
                        <li><a href="">obchodní podmínky</a></li>
                        <li><a href="">zpracování osobních údajů</a></li>
                        <li><a href="">o nás</a></li>
                    </ul>
                </div>
                <div>
                    <h3>jak nakoupit</h3>
                    <ul>
                        <li><a href="">možnosti dopravy</a></li>
                        <li><a href="">možnosti platby</a></li>
                        <li><a href="">reklamace a vrácení</a></li>
                    </ul>
                </div>
            </div>
            <div id="partners">
                <div>
                    <h3>spolupracujeme s</h3>
                </div>
                <div>
                    <a href="http://www.robedent.com/" target="_blank"><img src="assets/img/robedent.png" alt="robedent-logo" class="partner-logo"></a>
                </div>
            </div>
            <div id="copy">
                <span>© 2019 Dobrý kartáček. All rights reserved.</span>
            </div>
        </div>
    </section>
</main>
<script type="text/javascript" src="assets/js/main.js"></script>
</body>
</html>