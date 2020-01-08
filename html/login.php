<?php

    use db\DB; 
    use model\Utilisateur;

    include_once $_SERVER['DOCUMENT_ROOT'].'/includes.php';
    try{
        if(isset($_POST["token"]) && $_POST["token"] == $_SESSION["post-token"]){//vérification des tokens
            $result = DB::findByPseudo(Utilisateur::$TABLE,$_POST["username"]);//recherche des pseudos
            if($result){
                $user = $result[0];
                if(password_verify($_POST["password"],$user['password'])){//comparaison des hash
                    $currentUser = new Utilisateur($user[Utilisateur::$COL_ID],$user[Utilisateur::$COL_PSEUDO],$user[Utilisateur:: $COL_PASSWORD],
                        $user[Utilisateur::$COL_TYPE],$user[Utilisateur::$COL_ACTIF]);
                    $_SESSION["user"]=$currentUser;//utilisateur courant
                    header('Location: index.php');//redirection vers index
                    exit();
                }
            } 
            header('Location: login-view.php?error=1');
            exit();
        }else{
            header('Location: invalid-request.php');
            unset($_SESSION["post-token"]);
            exit();
        }
    }catch(\Error $e){
        header('Location: error.php');
        exit();
    }
    catch(\Exception $e){
        header('Location: error.php');
        exit();
    }
