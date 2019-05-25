<?php

    require_once $_SERVER['HTTP_REFERER'] . '/assets/php/handlers/user/confirm_password_reset.php';

?>
<html>
    <head>
        <title>Obnova hesla</title>
    </head>
    <body>
        <form action="handlers/user/password_reset.php" method="POST">
            <input type="password" name="password_new" required>
            <input type="password" name="password_new_confirm" required>
            <input type="hidden" name="token" value="<?php echo $_GET['t']; ?>">
            <input type="submit" value="Nastavit nové heslo">
        </form>
    </body>
</html>
