<?php
    /**
     * Gestion de la suppression d'un utilisateur
     */
    use model\Utilisateur;

    include_once $_SERVER['DOCUMENT_ROOT'].'/includes.php';
    if(!isset($_GET["token"]) || $_GET["token"] != $_SESSION["get-token"] ){//vérification du token
        header("Location: invalid-request.php");//token invalide
        unset($_SESSION["get-token"]);//suppression du token coté serveur pour éviter un brute force
    }
    else{
        if($_SESSION["user"]->type == 1){//contrôle d'accès
            try{
                $user = Utilisateur::find($_GET["id"]);
                $user->desactiver();
                header("Location: success.php");
            }catch(\Error $e){
                header("Location: error.php");
            }
            catch(\Exception $e){
                header("Location: error.php");
            }
        }else{
            header("Location: unauthorized.php");//accès refusé
        }
    }
    exit;