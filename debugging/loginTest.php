<?php
    require_once '../assets/php/includes/config.php';
    if ( !isset($_SESSION['user-id']) ) {
        header('Location: index.php');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
    <a href="../assets/php/user_Logout.php">logout</a>
    <?php
        if ( isset($_SESSION['notification']) )
            unserialize($_SESSION['notification'])->show();
    ?>
</body>
</html>