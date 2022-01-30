<?php
    session_start(); // initialise la session
    
    session_unset(); // désactive la session


    header('location: index.php');
    exit; // termine le script courant, peut afficher un message avant de le terminer

?>