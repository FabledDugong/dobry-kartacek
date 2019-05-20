<?php
    require_once 'includes/config.php';
    $DM = new DatabaseManager();
    $products = $DM->product_SelectAllBySubCategory($_POST['param']);
    echo json_encode($products);
?>