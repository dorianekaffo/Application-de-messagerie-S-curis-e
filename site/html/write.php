<?php
/**
 * Gestion de l'écriture d'un message
 */
include_once $_SERVER['DOCUMENT_ROOT'].'/includes.php';
if (!isset($_SESSION["user"])) {
  header("location: login-view.php");
}

use db\DB;
use model\Message;

if(isset($_POST["token"]) && $_POST["token"] == $_SESSION["post-token"]){
  echo "<pre>";
  if(!isset($_POST['target'])){
    $_SESSION["msg"] = "Le destinataire selectionné n'existe pas !";
    header("location: write-view.php?err");
    exit;
  }
  $dest = DB::find("utilisateur", $_POST["target"]);   
  Message::create($_SESSION["user"]->id, $dest["id"], htmlspecialchars($_POST["message"]), htmlspecialchars($_POST["topic"]));
  header("location: success.php");
}else{
  header("location: invalid-request.php");
  unset($_SESSION["post-token"]);
}
