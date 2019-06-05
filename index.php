<?php
require_once 'assets/php/includes/config.php';
$DM = new DatabaseManager();
$products = $DM->product_SelectAll();
$categories = $DM->category_SelectTop();

if (!isset($_SESSION['shopping-cart']))
    $cart = new ShoppingCart();
else
    $cart = unserialize($_SESSION['shopping-cart']);

?>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dobrý kartáček</title>
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="mask-icon" href="safari-pinned-tab.svg" color="#000000">
    <meta name="apple-mobile-web-app-title" content="Dobr&yacute; kart&aacute;ček">
    <meta name="application-name" content="Dobr&yacute; kart&aacute;ček">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
</head>
<body>
<div id="modal">
    <div id="login">
        <div id="login-control">
            <img src="assets/img/close.svg" data-role="button-modal-close" alt="close-button" class="icon">
        </div>
        <h3>přihlásit se</h3>
        <form action="assets/php/user_Login.php" method="post" name="login-form" id="login-form">
            <input required type="text" placeholder="E-mail" name="login-acc" id="login-acc" maxlength="30">
            <input required type="password" placeholder="Heslo" name="login-pass" id="login-pass">
            <input required type="submit" value="Přihlásit se">
        </form>
        <span>Nechcete nakupovat anonymně? <u data-role="link-signup">Registrujte se!</u></span>
    </div>
    <div id="signup">
        <div id="signup-control"><img src="assets/img/close.svg" data-role="button-modal-close" alt="close-button"
                                      class="icon"></div>
        <h3>registrovat se</h3>
        <form action="assets/php/user_Register.php" method="post" name="signup-form" id="signup-form">
            <div>
                <input type="email" placeholder="E-mail" name="signup-acc" id="signup-acc">
<!--                <label for="signup-acc"></label>-->
                <input type="password" placeholder="Heslo" name="signup-pass" id="signup-pass">
<!--                <label for="signup-pass"></label>-->
                <input type="password" placeholder="Potvrzení hesla" id="signup-pass2">
<!--                <label for="signup-pass"></label>-->
            </div>
            <div>
                <input required type="text" placeholder="Jméno a příjmení" name="signup-name" id="signup-name">
                <input required type="text" placeholder="Ulice, č. popisné" name="signup-address" id="signup-address">
                <input required type="text" placeholder="Město, PSČ" name="signup-address2" id="signup-address2">
                <input required type="text" placeholder="Telefonní číslo" name="signup-phone" id="signup-phone">
                <div>
                    <input type="checkbox" id="consent-terms">
                    <label for="consent-terms">Souhlasím s &#160;<a href="important/index.html#terms">Obchodními podmínkami</a>.</label>
                </div>
                <div>
                    <input type="checkbox" id="consent-personal">
                    <label for="consent-personal">Souhlasím se &#160;<a href="important/index.html#data">Zpracováním osobních údajů.</a></label>
                </div>
                <input type="submit" value="Potvrdit registraci">
            </div>
        </form>
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
                if ( !isset($_SESSION['user-id']) )
                    echo '<a data-role="button-open-login">přihlášení</a>';
                else
//                        if admin =>administrace
//                        if () {
//
//                        }
                    echo '<a href="debugging/loginTest.php">administrace</a>';
                ?>
                <a href="checkout/index.php" data-role="button-open-cart" id="ct">košík</a>
            </div>
        </nav>

        <div>
            <div>
                <h1>Dobrý<br>kartáček</h1>
                <p>
                    je základem každého dobrého úsměvu.
                </p>
            </div>
            <div>
                <div></div>
                <div></div>
                <div></div>
            </div>
            <button>eshop</button>
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
            foreach ($categories as $cat) {
                $subCategories = $DM->category_SelectSub($cat->id);

                echo "<div class='category' data-id='{$cat->id}'>
                                <div><h3>{$cat->name}</h3></div>";

                foreach ($subCategories as $subCat)
                    echo "<div class='subcategory' data-id='{$subCat->id}'>
                                <h3>{$subCat->name}</h3>
                              </div>";

                echo "</div>";
            }
            ?>
        </div>
        <div id="products">
            <?php
            foreach ($products as $prod) {
                $instock = ($prod->getStock() > 0) ? 'Skladem' : 'Není skladem';
                echo
                "<div class='product' id='product{$prod->getId()}' data-id='{$prod->getId()}' style='background: url(\"assets/img/products/{$prod->getPictures()}\") no-repeat center center / contain'>
                    <div>
                        <h4>{$prod->getName()}</h4>
                        <div>
                            <p>{$prod->getPrice()} Kč</p>
                            <p>{$instock}</p>
                        </div>
                    </div>
                </div>";
            }

            /*
                foreach ($products as $p)
                    echo "<div class='product' id='product{$p->getId()}' data-id='{$p->getId()}' style='background: url(\"assets/img/products/{$p->getPictures()}\") no-repeat center center / contain'>
                            <div>
                                <h4>{$p->getName()}</h4>
                            </div>
                         </div>";
            */

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
                            <label for="cnt">počet kusů</label>
                            <input type="number" value="1" name="cnt" id="cnt">
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
                        <li>Víta Nejedlého 655</li>
                        <li>Chrudim</li>
                        <li>537 01</li>
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
                        <li><a href="important/index.html#terms" target="_blank">obchodní podmínky</a></li>
                        <li><a href="important/index.html#data">reklamační řád</a></li>
                        <li><a href=""></a>zpracování osobních údajů</li>
                    </ul>
                </div>
                <div>
                    <h3>jak nakoupit</h3>
                    <ul>
                        <li><a href="important/index.html#optionsp">možnosti dopravy</a></li>
                        <li><a href="important/index.html#optionst">možnosti platby</a></li>
                        <li><a href="important/index.html#optionsc">možnosti reklamace a vrácení</a></li>
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
                <span>© 2019 Dobrý kartáček. Všechna práva vyhrazena.</span>
            </div>
        </div>
    </section>
</main>
<?php
    if ( isset($_SESSION['notification']) )
        unserialize($_SESSION['notification'])->show();
?>
<script type="text/javascript" src="assets/js/main.js"></script>
<script type="text/javascript" src="assets/js/ajax.js"></script>
</body>
</html>