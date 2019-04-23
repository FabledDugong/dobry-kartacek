<?php
    require_once 'includes/config.php';
    $DM = new DatabaseManager();
    $product = $DM->product_SelectById($_POST['param']);
    echo json_encode($product);
?>