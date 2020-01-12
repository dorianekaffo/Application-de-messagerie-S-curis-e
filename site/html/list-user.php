<?php
/**
 * Liste des utilisateurs
 */
include_once $_SERVER['DOCUMENT_ROOT'].'/includes.php';
if (!isset($_SESSION["user"])) {
  header("location: login-view.php");
}
if($_SESSION["user"]->type != 1){
    header("location: unauthorized.php");
}
$_SESSION["menu"]="Liste des utilisateurs";
include $_SERVER['DOCUMENT_ROOT'].'/csrf-get-type-token.php';
use db\DB;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel ="stylesheet" href="assets/css/bootstrap.css">
    <link rel ="stylesheet" href="style/app.css">
    <link rel ="stylesheet" href="style/list-user.css">
    <title>Messagerie</title>
</head>
<body>
    <?php include("header.php") ?>
    <div class="container-fluid main">
        <div class="row h-100">
            <?php include("app-bar.php") ?>
            <div class="col-md-9 content">
                <div class="panel panel-primary">
                    <div class="panel-heading">Liste des utilisateurs</div>
                    <div class="panel-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                <th>Id</th>
                                <th>Pseudo</th>
                                <th>Mot de Passe (Hash)</th>
                                <th>Admin</th>
                                <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if (isset($_GET['page_no']) && $_GET['page_no']!="") {
                                        $page_no = $_GET['page_no'];//numéro de la page pour la pagination. 1 si non définit
                                    } else {
                                        $page_no = 1;
                                    }
                                    $offset = ($page_no-1) * 6;//le numéro de ligne à partir duquel on récupère les enregistrements dans la table. on récupère 6 lignes
                                    $previous_page = $page_no - 1;//page précedente
                                    $next_page = $page_no + 1;//page suivante
                                    $result_count = DB::getDB()->query("SELECT COUNT(*) As total_records FROM utilisateur")->fetchAll();//nombre total d'utilisateur
                                    $total_records = $result_count[0];
                                    $total_records = $total_records['total_records'];
                                    $total_no_of_pages = ceil($total_records / 6);//nombre total de pages
                                    $second_last = $total_no_of_pages - 1; 
                                    $users = DB::getDB()->query("SELECT * from utilisateur limit ".$offset.", 6")
                                    ->fetchAll();//on obtient ainsi les 6 enregistrements à partir du offset
                                    foreach($users as $user){
                                        $str = "<tr>
                                        <td>".$user['id']."</td>
                                        <td>".$user['pseudo']."</td>
                                        <td>".$user['password']."</td>";
                                        if($user['Type'] == 1){
                                            $str.= "<td>Oui</td>";
                                        }else{
                                            $str.= "<td>Non</td>";   
                                        }
                                        $thisuser = ($_SESSION['user']->id == $user['id']) ? "disabled=true" : "";
                                        $str.="<td><a href=\"modify-user-view.php?id=".$user['id']."&token=".$_SESSION["get-token"]."\"><button class='modify'>Modifier</button></a>
                                        <a href=\"delete-user.php?id=".$user['id']."&token=".$_SESSION["get-token"]."\"><button ".$thisuser." class='delete'>Supprimer</button></a></td>";
                                        echo $str;
                                    }                          
                                ?>
                            </tbody>
                        </table>
                        <div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
                            <strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
                        </div>
                        <div>
                            <?php include("link.php");?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>