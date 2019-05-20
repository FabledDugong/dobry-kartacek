<?php
    require_once 'includes/config.php';
    require_once 'includes/fpdf181/fpdf.php';

    $DM = new DatabaseManager();
    $PDF = new FPDF();

    $PDF->AddPage();
    $PDF->AddFont( 'Arial', '', 16 );

    $PDF->Output( 'D', "../invoices/$filename.pdf" );
?>