<?php
/**
 * Formulaire de modification de mot de passe
 */
include_once $_SERVER['DOCUMENT_ROOT'].'/includes.php';
if (!isset($_SESSION["user"])) {
  header("location: login-view.php");
}
$_SESSION["menu"]="Modifier son mot de passe";
use model\Utilisateur;
$user = $_SESSION['user'];
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
                    <div class="panel-heading">Modifier son mot de passe </div>
                    <div class="panel-body">
                        <form action="modify-password.php" method="POST">
                            <?php include $_SERVER['DOCUMENT_ROOT'].'/csrf-post-type-token.php';?>
                            <input type="hidden" name="token" value="<?=$_SESSION["post-token"]?>">
                            <div class="form-group row">
                                <div class="col-md-5">
                                    <label for="password" class="col-form-label">Nouveau mot de passe</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="password" name="password" id="password" required class="form-control" placeholder="Mot de passe">
                                </div>
                            </div>
                            <div class="form-group row text-center">
                                <div class="col-md-12"><input type="submit" class="btn mb-2 submit" value="Modifier"></div>
                                <?php
                                    if(isset($_GET["error"])){
                                        echo '<div class="col-md-12 error">Le mot de passe doit contenir au moins contenir un chiffre, un caractère 
                                        spécial et doit au moins avoir 8 caractères</div>';
                                    }
                                ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>