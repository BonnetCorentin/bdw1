<?php

function traiterRequete($requete)
{
  $user = "p1703505" ;
  $mdp = "d86a2a" ;
  $machine = "localhost" ; // machine locale
  $bd = "p1703505" ;
  $connexion = mysqli_connect($machine,$user,$mdp, $bd) ;
  mysqli_set_charset ($connexion,'utf8');
  if(mysqli_connect_errno()) // erreur si > 0
    printf("Échec de la connexion : %s",mysqli_connect_error()) ;
  else { // utilisation de la base
  $tableauRetourne = array() ;
  $resultat = mysqli_query($connexion, $requete) ;
    if($resultat == FALSE) // échec si FALSE
      printf("Échec de la requête") ;
    else {
      $finfo = mysqli_fetch_fields($resultat);
      $entete=array() ;
      foreach ($finfo as $val) {
        $entete=$val;
      }
      $tableauRetourne[0]=$entete ;
      $cpt=1 ;
      while ($ligne = mysqli_fetch_array($resultat)) {
        $tableauRetourne[$cpt++]= $ligne ;
      }
    }
  }
  return $tableauRetourne;
  mysqli_close($connexion) ;
}

function modifierLaTable ($requete)
{
  $user = "p1703505" ;
  $mdp = "d86a2a" ;
  $machine = "localhost" ; // machine locale
  $bd = "p1703505" ;
  $connexion = mysqli_connect($machine,$user,$mdp, $bd) ;
  mysqli_set_charset ($connexion,'utf8');
  if(mysqli_connect_errno()) // erreur si > 0
    printf("Échec de la connexion : %s",mysqli_connect_error()) ;
  else {
    $resultat = mysqli_query($connexion, $requete) ;
      if($resultat == FALSE) // échec si FALSE
        printf("Échec lors de la modification de la table") ;
  }
  mysqli_close($connexion) ;
}

 ?>
