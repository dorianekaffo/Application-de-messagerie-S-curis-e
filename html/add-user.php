<?php
    /**
     * Gestion du formulaire d'ajout d'un utilisateur
     */
    use model\Utilisateur;
    use model\Util;
    include_once $_SERVER['DOCUMENT_ROOT'].'/includes.php';
    if($_SESSION["user"]->type == 1){
        if(isset($_POST["token"]) && $_POST["token"]==$_SESSION["post-token"]){
            if(Util::checkPassword($_POST['password'])){//on vérifie la conformité du mot du passe, cf la classe model/Util
                if(isset($_POST["admin"]))$admin = 1;
                else $admin = 0;
                Utilisateur::create($_POST["username"],$_POST["password"],$admin,1);
                header("Location: success.php");
            }else{
                header("Location: add-user-view.php?error=1");
            }
        }else{
            header("Location: invalid-request.php");  
            unset($_SESSION["post-token"]);      
        }
    }
    else
    header("Location: unauthorized.php");
    exit;