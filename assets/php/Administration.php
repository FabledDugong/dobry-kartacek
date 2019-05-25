<?php

    require_once 'includes/Initiate.php';

    if ( !isset( $_SESSION['user'] ) )
        $DM -> redirect( '../../index.php', 'Nejste přihlášeni', NOTIFICATION );

?>