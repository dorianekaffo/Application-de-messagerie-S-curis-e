<?php
    use model\Utilisateur;
    use model\Util;

    include_once $_SERVER['DOCUMENT_ROOT'].'/includes.php';
    if(isset($_POST["token"]) && $_POST["token"] == $_SESSION["post-token"]){
        if(Util::checkPassword($_POST['password'])){
            $user = $_SESSION['user'];
            $user->update($user->pseudo,$_POST['password'],$user->type,$user->actif);
            header("Location: success.php");
        }else{
            header("Location: modify-password-view.php?error=1");
        }
    }else{
        header("Location: invalid-request.php");
        unset($_SESSION["post-token"]);
    }
    exit;