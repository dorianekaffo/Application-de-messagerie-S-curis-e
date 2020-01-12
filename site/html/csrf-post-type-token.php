<?php
    /**
     * Génération du token des requêtes POST
     */
    $length = 32;
    $_SESSION['post-token'] = 
    substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $length);
?>