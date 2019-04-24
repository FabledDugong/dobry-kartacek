<?php
    session_start();
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
    <a href="../assets/php/logout.php">logout</a>
</body>
</html>