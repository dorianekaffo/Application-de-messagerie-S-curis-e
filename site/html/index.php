<?php
/**
 * Boite de réception
 */
include_once $_SERVER['DOCUMENT_ROOT'].'/includes.php';
if (!isset($_SESSION["user"])) {
  header("location: login-view.php");
}
include $_SERVER['DOCUMENT_ROOT'].'/csrf-get-type-token.php';//génération du token
$_SESSION["menu"]="Boîte de reception";
use model\Utilisateur;

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
                    <div class="panel-heading">Boîte de réception</div>
                    <div class="panel-body">
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Sujet</th>
                                <th scope="col">Expediteur</th>
                                <th scope="col">Destinataire</th>
                                <th scope="col">Date</th>
                                <th scope="col">Etat</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <?php
                                $allmessages = $_SESSION["user"]->messages();//les messages de l'utilisateur courant, $_SESSION['user'] contient l'utilisateur courant
                                $i=1;
                            ?>
                            <tbody>
                                <tr>
                                    <?php foreach($allmessages as $data){ ?>
                                         <tr>
                                            <td><?=$i++;?></td>
                                            <td><?=$data->sujet;?></td>
                                            <td><?=Utilisateur::find($data->id_expediteur)->pseudo;?></td>
                                            <td><?=Utilisateur::find($data->id_destinataire)->pseudo;?></td>
                                            <td><?=$data->date?></td>
              
                                            <?php if($data->statut == 1) { ?>
                                                <td>Lu</td>
                                                <?php } else { ?>
                                                <td>Pas lu</td>
                                            <?php } ?>
                                            <td><a href="details.php?id=<?=$data->id?>&token=<?=$_SESSION["get-token"]//token anti-csrf?>">Details</a></td>
                                        </tr>
                                    <?php } ?>
                                    <?php if($i==1) { ?>
                                        <tr>
                                            <td colspan="7" class="text-center">Aucun message</td>
                                        </tr>
                                    <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>