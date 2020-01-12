<?php
    /**
     * Génération du token des requêtes GET
     */
    $length = 32;
    $_SESSION['get-token'] = 
    substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $length);
?>