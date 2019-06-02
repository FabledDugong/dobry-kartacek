<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/dobry-kartacek/assets/php/includes/Autoloader.php';

    $DM = new DatabaseManager();

    $_POST = $DM -> sanitize( $_POST );

    $DM -> product_Insert(
        new Product(
            null,
            $_POST['id_category'],
            $_POST['id_manufacturer'],
            $_POST['name'],
            null,
            null,
            $_POST['description'],
            $_POST['color'],
            $_POST['toughness'],
            $_POST['price'],
            $_POST['stock'],
            $_FILES['pictures']['name']
        )
    );

    for ( $i = 0, $cnt = count( $_FILES['pictures']['name'] ); $i < $cnt; $i++ )
        if ( $_FILES['pictures']['tmp_name'][$i] != '' )
            move_uploaded_file( $_FILES['pictures']['tmp_name'][$i], '../img/products/' . $_FILES['pictures']['name'][$i]  );

    $DM -> redirect( '/assets/php/Administration.php', 'Produkt přidán', SUCCESS );

?>