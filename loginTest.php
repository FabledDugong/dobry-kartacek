<?php
    if ( !isset($_SESSION['user-id']) ) {
        header('Location: ' . $_SERVER['DOCUMENT_ROOT'] . '/index.php');
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
    <a href="assets/php/logout.php">logout</a>
</body>
</html>