<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/dobry-kartacek/assets/php/includes/Autoloader.php';

    $DM = new DatabaseManager();

    $_POST = $DM -> sanitize( $_POST );

    $product = $DM -> product_SelectById( $_POST['id'] );

    if ( !empty( $_POST['id_category'] ) )
        $product -> id_category = $_POST['id_category'];

    if ( !empty( $_POST['id_manufacturer'] ) )
        $product -> id_manufacturer = $_POST['id_manufacturer'];

    if ( !empty( $_POST['name'] ) )
        $product -> name = $_POST['name'];

    if ( !empty( $_POST['description'] ) )
        $product -> description = $_POST['description'];

    if ( !empty( $_POST['color'] ) )
        $product -> color = $_POST['color'];

    if ( !empty( $_POST['toughness'] ) )
        $product -> toughness = $_POST['toughness'];

    if ( !empty( $_POST['price'] ) )
        $product -> price = $_POST['price'];

    if ( !empty( $_POST['stock'] ) )
        $product -> stock = $_POST['stock'];

    if ( !empty( $_FILES['pictures']['name'] ) )
        foreach ( $_FILES['pictures']['name'] as $p )
            if ( !in_array( $p, $product -> pictures ) )
                $product -> pictures[] = $p;

    for ( $i = 0, $cnt = count( $product -> pictures ); $i < $cnt; $i++ )
        if ( !in_array( $product -> pictures[$i], $_FILES['pictures']['name'] ) )
            unset( $product -> pictures[$i] );

    $DM -> product_Update( $product );

    for ( $i = 0, $cnt = count( $_FILES['pictures']['name'] ); $i < $cnt; $i++ )
        if ( $_FILES['pictures']['tmp_name'][$i] != '' )
            move_uploaded_file( $_FILES['pictures']['tmp_name'][$i], '../img/products/' . $_FILES['pictures']['name'][$i]  );

    $DM -> redirect( '/assets/php/Administration.php', 'Produkt upraven', SUCCESS );

?>