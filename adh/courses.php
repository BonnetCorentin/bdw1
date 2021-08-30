<?php
  if (session_id()== "") session_start(); // si une session n'est pas en cours en démarrer une
  require_once('.././connexionBD.php');
  $requete = "SELECT idA FROM Utilisateur WHERE pseudo='".$_SESSION["slogin"]."'"; // requete pour trouver l'idA en fonction du login
  $tableau =traiterRequete($requete);
  $idA= $tableau[1]['idA'];
  $requete = "SELECT nom,prenom FROM Adherent WHERE ida = $idA"; // requete pour trouver le nom et prenom de l'adherent
  $tableau=traiterRequete($requete);
  if (isset ($tableau[1])){
    $nom = $tableau[1]['nom'];
    $prenom = $tableau[1]['prenom'];
    $requete ="SELECT DISTINCT COUNT(*) FROM Resultat WHERE nom='".$nom."' AND prenom ='".$prenom."'"; // requete pour compter le nombre de course que l'adherent en question a parcouru
    $tableau = traiterRequete($requete);
    $nbCourse = $tableau[1][0];
    $requete = "SELECT E.Annee,Ty.distance,C.nom, MAX(Te.temps) AS temps FROM Course C NATURAL JOIN Edition E NATURAL JOIN Epreuve Ep NATURAL JOIN TypeEpreuve Ty JOIN Resultat R ON R.idEdition = E.idEdition AND R.idE = Ep.idE JOIN TempsPassage Te ON Te.idEdition = E.idEdition AND Te.idE = Ep.idE AND Te.dossard = R.dossard WHERE R.nom= '".$nom."' AND R.prenom = '".$prenom."' GROUP BY R.dossard ORDER BY E.annee DESC, Ty.distance DESC,Te.temps"; // requete donnant les informations relatives aux courses et editions parcouru par l'adherent
    $tableau = traiterRequete($requete);
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap/bootstrap.css"  media="all"/>
    <title>La Grammondsion</title>
  </head>
    <body class="p-3 mb-2 bg-dark text-white">
      <a class="btn btn-outline-warning col-1 offset-11" href=".././espacePerso.php">Retour</a>
      <a class="btn btn-outline-warning col-1 offset-11" href=".././deconnexion.php">Déconnexion</a>
      <h1 class="display-1 text-center">Profil adhérent de <?php print $_SESSION ["slogin"]; ?> </h1>
      <h5 class="display-5 text-center"> Voici la liste des courses que vous avez courus </h5>
      <ul>
  <?php
  $compte =1; // compteur de course
  $sauter =false; // booleen verifiant si deux courses ont des similitudes
  foreach ($tableau as $key => $value) // parcours le tableau
  {
    if (!$sauter){ // si aucune similitude entre deux lignes
      if ($key!=0){
        if ($compte <= $nbCourse){ // si $key est inferieur aux nombres de courses parcourues
          $key = $compte; // afin de voir si la course n'a pas deja ete ajoute
            $affichage = '<li>'.$value["Annee"].''; // mise en place du tableau dans la variable $affichage
              $affichage .= '<ul>';
                $affichage .= '<li class="list-group-item list-group-item-dark">'.$value["distance"].'km';
                  $affichage .='<ul>';
                    $affichage .= '<li class="list-group-item list-group-item-dark">'.$value["nom"].'('.$value["temps"].' minutes)</li>';
                    if ($key +1 < $nbCourse && $tableau[$key][0] == $tableau[$key+1][0] && $tableau[$key][1]==$tableau[$key+1][1]){ // regarde si deux courses ont une annee identiques et une meme distance
                      $affichage.='<li class="list-group-item list-group-item-dark">'.$tableau[$key+1][2].'('.$tableau[$key+1][3].' minutes)</li>'; // auquel cas ajoute la deuxieme courses
                      $compte=$key+1;
                      $sauter=true;
                    }
                    $affichage .='</ul>';
                    $affichage .='</li>';
                    if ($key +1 < $nbCourse && $tableau[$key][0]==$tableau[$key+1][0]) // regarde si meme annee entre deux courses
                    {
                      $affichage .= '<li class="list-group-item list-group-item-dark">'.$tableau[$key +1][1].'km'; // ajoute distance de la deuxieme courses
                      $affichage.='<ul>';
                      $compte=$key+1;// incremente le nombre de course rentre
                      $sauter =true;
                      $affichage.='<li class="list-group-item list-group-item-dark">'.$tableau[$key+1][2].'('.$tableau[$key+1][3].' minutes)</li>';
                      if ($key +1 < $nbCourse && $tableau[$key][0] == $tableau[$key+1][0] && $tableau[$key+1][1]==$tableau[$key][1]){ // compare la deuxieme a la troisieme courses
                        $affichage.='<li class="list-group-item list-group-item-dark">'.$tableau[$key+1][2].'('.$tableau[$key+1][3].' minutes)</li>';
                        $compte = $key+1;
                        $sauter=true;
                      }
                      $affichage.='</ul>';
                      $affichage .= '</li>';
                    }
                    $affichage .= '</ul>';
                    $affichage .= '</li>';
                    print $affichage; // affiche la tableau
                  }
                }
              }
              else $sauter=false;
            }
?>
  <div class= "container">
    <div class="text-center">
      <img src = "../Coureur2.png" class="image-fluid w-25" >  <!-- Image du coureur-->
    </div>
  </div>
  </body>
</html>
