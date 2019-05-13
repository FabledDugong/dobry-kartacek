<?php
    require_once 'includes/config.php';
    unset($_SESSION['user-id']);
    new Notification('Successfully logged out.');
    header('Location: ../../index.php');
    exit;
?>