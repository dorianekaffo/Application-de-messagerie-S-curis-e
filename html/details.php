<?php
/**
 * Page sur les détails d'un message
 * On reçoit par $_GET l'id du message
 */
include_once $_SERVER['DOCUMENT_ROOT'].'/includes.php';
if (!isset($_SESSION["user"])) {
  header("location: login-view.php");
}
if(!isset($_GET["token"]) || $_GET["token"] != $_SESSION["get-token"] ){//token anti-csrf
    header("Location: invalid-request.php");
    unset($_SESSION["get-token"]);
}
$_SESSION["menu"]="Détails du message";
use model\Utilisateur;
use model\Message;

try{
    $message = Message::find($_GET['id']);
    $message->updateVu();//le message passe en lu
    $sender = Utilisateur::find($message->id_expediteur);//On récupère l'expéditeur du message
}catch(\Error $e){
    header("Location: error.php");
}catch(\Exception $e){
    header("Location: error.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel ="stylesheet" href="assets/css/bootstrap.css">
    <link rel ="stylesheet" href="style/app.css">
    <link rel ="stylesheet" href="style/index.css">
    <title>Messagerie</title>
</head>
<body>
    <?php include("header.php") ?>
    <div class="container-fluid main">
        <div class="row h-100">
            <?php include("app-bar.php") ?>
            <div class="col-md-9 content">
                <div class="panel panel-primary">
                    <div class="panel-heading">Détails sur le message </div>
                    <div class="panel-body">
                        <form action="handle-details.php" method="POST">
                            <?php include $_SERVER['DOCUMENT_ROOT'].'/csrf-post-type-token.php';//génération du token?>
                            <input type="hidden" name="token" value="<?=$_SESSION["post-token"]?>">
                            <input type="hidden" name="message" value="<?=$message->id /*en envoi l'id du message pour 
                            gérer la suppression ou la réponse au message*/?>">
                            <div class="form-group row">
                                <div class="col-md-5">
                                    <label for="sender" class="col-form-label">Expéditeur</label>
                                </div>
                                <div class="col-md-6">
                                   <input disabled type="text" value="<?= $sender->pseudo?>" name="sender" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-5">
                                    <label for="topic" class="col-form-label">Sujet</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" disabled value="<?=$message->sujet?>" name="topic" id="topic" class="form-control" placeholder="Sujet">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-5">
                                    <label for="message" class="col-form-label">Corps du message</label>
                                </div>
                                <div class="col-md-6">
                                    <textarea name="message" disabled class="form-control" id="message" cols="30" rows="10"><?=$message->message?></textarea>
                                </div>
                            </div>
                            <div class="form-group row text-center">
                                <div class="col-md-6"><input type="submit" name="respond" class="btn mb-2 submit" value="Répondre"></div>
                                <div class="col-md-6"><input type="submit" name="delete" class="btn mb-2 submit" value="Supprimer"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>