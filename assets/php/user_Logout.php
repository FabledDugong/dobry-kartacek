<?php
    require_once 'includes/config.php';
    unset($_SESSION['user-id']);
    new Notification('Odhlášení proběhlo úspěšně.');
    header('Location: ../../index.php');
    exit;
?>