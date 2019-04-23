<?php
    mb_internal_encoding('UTF-8');
    session_start();

    spl_autoload_register(function ($class) {
        require_once($_SERVER['DOCUMENT_ROOT'] . "/assets/php/includes/{$class}.php");
    });
?>