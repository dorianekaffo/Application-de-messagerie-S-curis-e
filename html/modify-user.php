<?php
    use model\Utilisateur;
    use model\Util;
    /**
     * Gestion de la modification d'un utilisateur
     */
    include_once $_SERVER['DOCUMENT_ROOT'].'/includes.php';
    if(isset($_POST["token"]) && $_POST["token"] == $_SESSION["post-token"]){
        if(Util::checkPassword($_POST["password"]) || $_POST["password"] == "" ){
            if($_SESSION["user"]->type == 1){
                if(isset($_POST["admin"]))$admin = 1;
                else $admin = 0;
                $actif = 1;
                $user = Utilisateur::find($_POST["id"]);
                $user->update($user->pseudo,$_POST["password"],$admin,$actif);
                header("Location: success.php");
            }else{
                header("Location: unauthorized.php");
            }
        }else{
            header("Location: modify-user-view.php?error=1&token=".$_SESSION["get-token"]."&id=".$_POST['id']);
        }
    }else{
        header("Location: invalid-request.php");
        unset($_SESSION["post-token"]);
    }
    exit;