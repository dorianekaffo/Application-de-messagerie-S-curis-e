<?php
    unset($_SESSION["user"]);
    session_start();//!important
    session_destroy();//!important
    header("location: login-view.php");
    exit();
    
    
