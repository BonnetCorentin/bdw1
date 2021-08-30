<?php

header ('content-type: text/html; charset=utf-8');
require_once('connexionBD.php');
session_start ();

if (isset($_POST["pLogin"])){
  $_SESSION["slogin"]= $_POST["pLogin"];
  $_SESSION["sPwd"]= $_POST["pPwd"];
  $pseudo = $_POST["pLogin"];
  $mdp = $_POST["pPwd"];
  }
  else
  {
    $pseudo=$_SESSION["slogin"];
    $mdp=$_SESSION["sPwd"];
  }
  $requete = "SELECT * FROM Utilisateur WHERE pseudo = '".$pseudo."' AND mot_de_passe = '".$mdp."'";
  $tableau = traiterRequete($requete);

if (isset ($tableau [1])){
  if ($tableau [1]["role"] == "Administrateur"){
    include ('./adm/accueil.php');
  }
  else if ($tableau [1]['idA'] == NULL){
    include ('./adh/fiche.php');
  }
  else {
    include ('./adh/accueil.php');
  }
}


else include ('./erreur.php');

?>
