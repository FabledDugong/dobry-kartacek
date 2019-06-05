<?php
    require_once 'includes/Initiate.php';

    if ( !isset( $_SESSION['user'] ) )
        $DM -> redirect( '../../index.php', 'Nejste přihlášeni', NOTIFICATION );

    $user = $DM -> user_SelectById( $_SESSION['user']['id'] );
    $invoices = $DM -> invoice_SelectAllByUserId( $_SESSION['user']['id'] );
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dobrý kartáček - uživatelský profil</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/profile.css">
</head>
<body>
<nav id="profile-control">
    <div id="brand">
        <a href="../index.php">
            <img class="logo" alt="logo" src="../assets/img/dk_logo.svg">
        </a>
    </div>
    <div id="menu">
        <ul>
            <li class="tab active" data-target="profile">Profil</li>
            <li class="tab" data-target="orders">Objednávky</li>
            <li class="tab" data-target="messages">Dotazy</li>
            <li id="logout"><a href="../assets/php/handlers/user/logout.php">Odhlásit se</a></li>
        </ul>
    </div>
    <div id="copy">
        <span>© 2019 Dobrý kartáček.</span>
        <span>Všechna práva vyhrazena.</span>
    </div>
</nav>
<main id="profile-content">
    <section id="profile">
        <h2>Profil uživatele</h2>
        <h3>Nastavení účtu</h3>
        <div>
            <table>
                <tr>
                    <td>
                        přihlašovací e-mail
                    </td>
                    <td>
                        <?php echo $user -> email ?>
                    </td>
                </tr>
            </table>
        </div>
        <h4>Změna hesla</h4>
        <div>
            <form action="">
                <div>
                    <input type="password" name="pass-orig" placeholder="Původní heslo">
                    <input type="password" name="pass-new" placeholder="Nové heslo">
                </div>
                <input type="submit" value="Změnit">
            </form>
        </div>

        <h3>Fakturační údaje</h3>
        <p><?php



            ?></p>
    </section>
    <section id="orders">
        <h2>Objednávky</h2>
        <table id="invoices">
            <tr>
                <th>číslo objednávky</th>
                <th>datum objednávky</th>
                <th>cena</th>
                <th>způsob dopravy</th>
                <th>uhrazena</th>
            </tr>
            <?php
                foreach ( $invoices as $i )
                    echo
                    "<div class='invoice'>";



                echo "</div>";
            ?>
        </table>
    </section>
    <section id="messages">
        prdelka
    </section>
</main>
<script type="text/javascript" src="../assets/js/profile.js"></script>
</body>
</html>