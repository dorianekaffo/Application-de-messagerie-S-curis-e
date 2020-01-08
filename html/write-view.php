<?php
/**
 * Formulaire d'écriture et de réponse à un message
 */
include_once $_SERVER['DOCUMENT_ROOT'].'/includes.php';
if (!isset($_SESSION["user"])) {
  header("location: login-view.php");
}
$_SESSION["menu"]="Nouveau message";
use model\Utilisateur;
use model\Message;

$message=null;//variable censée contenir l'id d'un message auquel on répond

try{
    if(isset($_GET['id'])){
        if(!isset($_GET["token"]) || $_GET["token"] != $_SESSION["get-token"]){
            header("location: invalid-request.php");
            unset($_SESSION["get-token"]);
        }
        $message = Message::find($_GET['id']);
        if($message == null){
            header("location: error.php");//l'id ne correpond à aucun message!      
        }
    }
}catch(\Exception $e){
    header("location: error.php");
}catch(\Error $e){
    header("location: error.php");
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
                    <div class="panel-heading">Envoyer un message </div>
                    <div class="panel-body">
                        <form action="write.php" method="POST">
                            <?php include $_SERVER['DOCUMENT_ROOT'].'/csrf-post-type-token.php';?>
                            <input type="hidden" name="token" value="<?=$_SESSION["post-token"]?>">
                            <div class="form-group row">
                                <div class="col-md-5">
                                    <label for="target" class="col-form-label">Envoyer à</label>
                                </div>
                                <div class="col-md-6">
                                    <select name="target" <?php if($message) echo "disabled"?> class="form-control" id="target">
                                        <?php
                                            $users = Utilisateur::all();
                                            foreach($users as $user){
                                                if($user->id != $_SESSION['user']->id){
                                                    if($message){
                                                        if($message->expediteur()->id == $user->id){
                                                            echo "<option selected value=".$user->id.">".$user->pseudo."</option>";
                                                            echo '<input name="target" type="hidden" value='.$user->id.'>';
                                                        }
                                                    }else
                                                    echo "<option value=".$user->id.">".$user->pseudo."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-5">
                                    <label for="topic" class="col-form-label">Sujet</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" <?php if(isset($_GET['id'])) echo " disabled value='".$message->sujet."'";?> name="topic" id="topic" class="form-control" placeholder="Sujet">
                                    <?php if($message) echo '<input name="topic" type="hidden" value="'.$message->sujet.'">';?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-5">
                                    <label for="message" class="col-form-label">Corps du message</label>
                                </div>
                                <div class="col-md-6">
                                    <textarea name="message" class="form-control" id="message" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="form-group row text-center">
                                <div class="col-md-12"><input type="submit" class="btn mb-2 submit" value="Envoyer"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>