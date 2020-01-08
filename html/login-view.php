<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel ="stylesheet" href="assets/css/bootstrap.css">
    <link rel ="stylesheet" href="style/app.css">
    <link rel ="stylesheet" href="style/login.css">
    <title>Messagerie|Connexion</title>
    <?php session_start(); ?>
</head>
<body>
    <div class="login-block">
        <div class="app-name">
            <span>Messagerie</span>
        </div>
        <form action="login.php" method="POST">
            <?php include $_SERVER['DOCUMENT_ROOT'].'/csrf-post-type-token.php'; //token anti-csrf?>
            <input type="hidden" name="token" value="<?=$_SESSION["post-token"]?>">
            <div class="form-group row">
                <div class="col-md-5">
                    <label for="login" class="col-form-label">Identifiant</label>
                </div>
                <div class="col-md-6">
                    <input type="text" name="username" required id="login" class="form-control" placeholder="Identifiant">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-5">
                    <label for="password" class="col-form-label">Mot de passe</label>
                </div>
                <div class="col-md-6">
                    <input type="password" name="password" required id="password" class="form-control" placeholder="Mot de passe">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-12"><input type="submit" id="submit" class="btn mb-2 submit" value="Se connecter"></div>
                <?php
                    if(isset($_GET["error"])){
                        echo '<div class="col-md-12 error">Nom d\'utilisateur ou mot de passe incorrecte</div>';
                    }
                ?>
            </div>
        </form>
    </div>
</body>
</html>