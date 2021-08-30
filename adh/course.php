<?php
  if (!isset ($_SESSION))
    session_start ();
  $requete = "SELECT Nom FROM Course;";
  require_once ('../connexionBD.php');
  $tableauRequete = traiterRequete ($requete); // requete pour recuperer les différentes courses et les mettre dans un tableau
?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap/bootstrap.css" media="all"/>
    <title>La Grammondsion</title>
  </head>
    <body class="p-3 mb-2 bg-dark text-white">
      <a class="btn btn-outline-warning col-1 offset-11" href=".././espacePerso.php">Retour</a> <!-- Bouton permettant de revenir a espacePerso.php et donc sur accueil -->
      <a class="btn btn-outline-warning col-1 offset-11" href=".././deconnexion.php">Déconnexion</a> <!-- Bouton permet de se deconnecter et donc d'aller vers la page deconnexion.php-->
        <h1 class='display-3 text-center'>Profil adherent</h1>
          <p class='display-4 text-center'>
            Bienvenue <?php print $_SESSION ["slogin"];?>
          </p>
    <div class="formulaire">
      <form method="post" action="course.php";?>  <!--Formulaire envoyant sur la même page-->
        <label for="liste_course">Veuillez saisir une course pour plus de détail</label><br/>
          <select name="liste_course" id="liste_course">
            <?php
              foreach ($tableauRequete as $key => $value) {
                if ($key != 0){
                  print ('<option value="'.$value['Nom'].'">'.$value ['Nom'].'</option>'); // boucle foreach afin de parcourir tout le tableau et d'en sortir uniquement les données qui nous interesse
                }
              }
            ?>
        </select>
        <input type="Submit" name="voir_course" value="Voir course">  <!-- Bouton pour voir les courses qui va envoyer le formulaire -->
      </form>
    </div>
    <div>
      <?php
        if (isset ($_POST["liste_course"])){ // regarde si le menu deroulant a ete selectionne
          print ('Vous avez selectionné la course : '.$_POST["liste_course"].'</br>'); // Affiche la valeur du menu déroulant
          $requete='SELECT E.annee,E.nbParticipant,E.adresseDepart,E.dateInscription,E.dateDepotCertificat,E.dateRecupDossard,E.url FROM Edition E JOIN Course C ON E.idC=C.idC WHERE C.nom="'.$_POST["liste_course"].'"'; // requete pour afficher les info relatives à une édition sur une course
          $tableauRequete = traiterRequete ($requete); // traite la requete dans un tableau
          foreach ($tableauRequete as $key => $value) { // parcours le tableau
            if ($key != 0){
              $affichage='Information sur la '.$key.' édition: ';
              $affichage.='<table id="tableau_edition" class="table table-striped table-dark"><tr><td>Année</td><td>Nombre de participants</td><td>Adresse de départ</td><td>Date des inscriptions</td><td>Date de depôt du certificat</td><td>Date de récupération du dossard</td><td>Lien vers le site</td></tr>';
              $affichage.='<tr><td>'.$value["annee"].'</td><td>'.$value["nbParticipant"].'</td><td>'.$value["adresseDepart"].'</td><td>'.$value["dateInscription"].'</td><td>'.$value["dateDepotCertificat"].'</td><td>'.$value["dateRecupDossard"].'</td><td><a href='.$value["url"].' target=_blank>Site</a></td></tr></table>'; // cree un tableau avec en cellules les informations du tableau de la requete
              print ($affichage); // affiche le tableau
            }
          }
        }
      ?>
    </div>

  </body>
</html>
