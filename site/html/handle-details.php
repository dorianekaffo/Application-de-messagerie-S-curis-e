<?php
    use db\DB; 
    use model\Utilisateur;
    use model\Message;

    /**
     * Gestion de la réponse/suppresion d'un message
     */

    include_once $_SERVER['DOCUMENT_ROOT'].'/includes.php';
    if(isset($_POST["token"]) && $_POST["token"] == $_SESSION["post-token"]){//vérification du token
        $message = Message::find($_POST['message']);// on construit le message à partir de l'id provenant l'input masqué du formulaire details
        if(isset($_POST['delete'])){//si Supprimer a été cliqué
            $message->delete();
            header("Location: success.php");
        }
        if(isset($_POST["respond"])){//si Répondre a été cliqué
            include $_SERVER['DOCUMENT_ROOT'].'/csrf-get-type-token.php';
            header("Location: write-view.php?id=".$message->id."&token=".$_SESSION["get-token"]);
        }
    }else{
        header("Location: invalid-request.php");
        unset($_SESSION["post-token"]);
    }

    
