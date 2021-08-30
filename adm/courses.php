<?php
  if (!isset ($_SESSION)) // si une session n'est pas en cours en démarrer une
  session_start ();
  require_once ('connexionBD.php');

  if (isset ($_POST["pValiderCourse"])){ // si l'utilisateur a validé la création d'une course
    $requete = 'INSERT INTO Course (nom,anneeCreation,mois) VALUES ("'.$_POST["Nom"].'","'.$_POST["AnneeCreation"].'","'.$_POST["Mois"].'")';// requête qui permet d'insérer une course dans la base de donnée
    modifierLaTable ($requete);
  }

  if (isset ($_POST["valider_ajout_edition"])){// si l'utilisateur a validé la création d'une édition
    $requete='SELECT idC FROM Course WHERE nom="'.$_POST["valider_ajout_edition_cache"].'"'; // requête qui permet de récuperer l'idC de la course lié à l'édition que l'utilisateur à crée
    $tableauRequete=traiterRequete ($requete);
    $requete = 'INSERT INTO Edition (idC,annee,nbParticipant,adresseDepart,dateInscription,dateDepotCertificat,dateRecupDossard,url) VALUES ("'.$tableauRequete[1][0].'","'.$_POST["annee"].'","'.$_POST["nbParticipant"].'","'.$_POST["adresseDepart"].'","'.$_POST["dateInscription"].'","'.$_POST["dateDepotCertificat"].'","'.$_POST["dateRecupDossard"].'","'.$_POST["url"].'")';
    // requête qui permet d'insérer une édition dans la base de donnée
    modifierLaTable ($requete);
  }

  if (isset ($_POST["Supprimer_edition"])){ // si l'utilisateur a supprimé une édition
    $requete='DELETE FROM Edition WHERE idEdition="'.$_POST["suppCache"].'"'; // requête qui permet de supprimer une édition de la base de donnée
    modifierLaTable ($requete);
  }

  if (isset ($_POST["Supprimer_course"])){ // si l'utilisateur a supprimé une course
    $requete='DELETE FROM Course WHERE idC="'.$_POST["supCourseCache"].'"'; // requête qui permet de supprimer une course de la base de donnée
    modifierLaTable ($requete);
  }
  if (isset ($_POST["liste_course"])){ // si l'utilisateur veut voir les informations sur une course
    $courseSelectionnee = $_POST["liste_course"]; // affectation du nom de la course sélectionné de la variable $courseSelectionnee
    $requete='SELECT anneeCreation,mois FROM Course WHERE nom="'.$courseSelectionnee.'"'; // requête qui permet de récuperer les informations sur la course sélectionnée
    $tableauRequete = traiterRequete ($requete);
    print ('<p class="text-center">Vous avez selectionné la course : '.$courseSelectionnee.'. Cette course a été crée en '.$tableauRequete[1]["anneeCreation"].' et elle a lieu au mois de '.$tableauRequete[1]["mois"].'. Nombre moyen de participant à la course: ');
    // affiche les informations sur la course sélectionnée
    $requete='SELECT AVG(E1.nbParticipant) FROM Edition E1 JOIN Edition E2 ON E1.idC = E2.idC JOIN Course C ON E1.idC = C.idC WHERE C.nom = "'.$courseSelectionnee.'"';
    // requête qui permet de récuperer le nombre moyen de participant à la course sélectionnée
    $tableauRequete = traiterRequete ($requete);
    print ($tableauRequete [1][0].'<br></p>'); // affiche le nombre moyen de participant à la course sélectionnée

    $requete='SELECT E.idEdition,E.annee,E.nbParticipant,E.adresseDepart,E.dateInscription,E.dateDepotCertificat,E.dateRecupDossard,E.url FROM Edition E JOIN Course C ON E.idC=C.idC WHERE C.nom="'.$courseSelectionnee.'"';
    // requête qui permet de récuperer les éditions de la course sélectionnée
    $tableauRequete = traiterRequete ($requete);

    foreach ($tableauRequete as $key => $value) { // boucle qui parcourt le tableau d'éditions
      if ($key != 0){ // si la ligne du tableau est différente de l'entête
        $affichage='<form method="post" action="espacePerso.php">';
        $affichage.='<div class="text-center display-4">Information sur l’édition de l’année '.$value["annee"].' : </div>';
        $affichage.='<table class="table table-striped table-dark"><tr><td>Nombre de participants</td><td>Adresse de départ</td><td>Date des inscriptions</td><td>Date de depôt du certificat</td><td>Date de récupération du dossard</td><td>Lien vers le site</td><td>Modifier édition</td><td>Supprimer édition</td></tr>';
        $affichage.='<tr><td>'.$value["nbParticipant"].'</td><td>'.$value["adresseDepart"].'</td><td>'.$value["dateInscription"].'</td><td>'.$value["dateDepotCertificat"].'</td><td>'.$value["dateRecupDossard"].'</td><td><a href='.$value["url"].' target=_blank>Site</a></td>';
        $affichage.='<td><input type="hidden" name="modifCache" value="'.$value["idEdition"].'">'; // input caché qui envoi l'idEdition de l'édition sélectionnée
        $affichage.='<input type="submit" name="modifier_edition"  class="btn btn-outline-light" value="Modifier"></td>';
        $affichage.='<td><input type="hidden" name="suppCache" value="'.$value["idEdition"].'">'; // input caché qui envoi l'idEdition de l'édition sélectionnée
        $affichage.='<input type="submit" name="Supprimer_edition" class="btn btn-outline-light" value="Supprimer édition"></td></tr></table></form>';
        // formulaire qui permet de supprimer ou de modifier une édition de la course sélectionnée
        print ($affichage);
        // affiche des tableaux avec toutes les informations sur les éditions de la course sélectionnée

        $requete='SELECT DISTINCT idE FROM Resultat WHERE idEdition="'.$value["idEdition"].'" ORDER BY idE';
        // requête qui permet de sélectionner les IdE des éditions de la course sélectionnée dans la table résultat
        $tableau=traiterRequete ($requete);

        if (isset ($tableau [1])){
          $tableauRequete =array (); // crée un tableau de requête
          $tableauRequete [0]= 'SELECT COUNT(*) AS Nombre FROM Adherent A JOIN Resultat R ON A.prenom = R.prenom AND A.nom = R.nom JOIN Edition E ON E.idEdition = R.idEdition WHERE E.idEdition = "'.$value["idEdition"].'" GROUP BY R.idE';
          // requête qui permet de récupèrer le nombre total d’adhérents ayant couru l’édition de la course sélectionnée
          $tableauRequete [1] ='SELECT COUNT(*) AS Nombre FROM Adherent A JOIN Resultat R ON A.prenom = R.prenom AND A.nom = R.nom JOIN Edition E ON E.idEdition = R.idEdition WHERE E.idEdition = "'.$value["idEdition"].'" AND A.nom_club IS NOT NULL GROUP BY R.idE';
          // requête qui permet de récupèrer le nombre total d’adhérents ayant couru l’édition en étant licencié à un club de la course sélectionnée
          $tableauRequete [2]='SELECT COUNT(DISTINCT A.nom_club) FROM Adherent A JOIN Resultat R ON A.prenom = R.prenom AND A.nom=R.nom WHERE R.idEdition = '.$value["idEdition"];
          // requête qui permet de récuperer le nombre de clubs d’athlétisme représentés durant l’édition de la course sélectionnée

          $tableauRequete [3]=array (); // l'indice 3 du tableau de requête devient un tableau sous requêtes
          $tableauRequete [3][0]='SELECT MIN(temps) FROM TempsPassage WHERE idEdition ='.$value["idEdition"].' AND idE = '.$tableau[1][0].'  AND km = 41';
          $tableauRequete [3][1]='SELECT MIN(temps) FROM TempsPassage WHERE idEdition ='.$value["idEdition"].' AND idE = '.$tableau[2][0].'   AND km = 21';
          $tableauRequete [3][2]='SELECT MIN(temps) FROM TempsPassage WHERE idEdition ='.$value["idEdition"].' AND idE = '.$tableau[3][0].'   AND km = 10';
          // requête qui permet de récuperer le temps de passage du vainqueur des éditions de la course sélectionnée

          $tableauRequete [4]=array (); // l'indice 4 du tableau de requête devient un tableau sous requêtes
          $tableauRequete [4][0]='SELECT MAX(temps) FROM TempsPassage WHERE idEdition ='.$value["idEdition"].' AND idE = '.$tableau[1][0].'   AND km = 41';
          $tableauRequete [4][1]='SELECT MAX(temps) FROM TempsPassage WHERE idEdition ='.$value["idEdition"].' AND idE = '.$tableau[2][0].'  AND km = 21';
          $tableauRequete [4][2]='SELECT MAX(temps) FROM TempsPassage WHERE idEdition ='.$value["idEdition"].' AND idE = '.$tableau[3][0].'   AND km = 10';
          // requête qui permet de récuperer le temps de passage du pire temps obtenu par un adhérent des éditions de la course sélectionné

          $tableauRequete [5]=array(); // l'indice 5 du tableau de requête devient un tableau sous requêtes
          $tableauRequete[5][0] = 'SELECT MAX(rang) FROM Resultat R JOIN Adherent A ON A.prenom =R.prenom AND R.nom = A.nom WHERE idEdition ='.$value["idEdition"].' AND idE = '.$tableau[1][0];
          $tableauRequete[5][1] = 'SELECT MAX(rang) FROM Resultat R JOIN Adherent A ON A.prenom =R.prenom AND R.nom = A.nom WHERE idEdition ='.$value["idEdition"].' AND idE = '.$tableau[2][0];
          $tableauRequete[5][2] = 'SELECT MAX(rang) FROM Resultat R JOIN Adherent A ON A.prenom =R.prenom AND R.nom = A.nom WHERE idEdition ='.$value["idEdition"].' AND idE = '.$tableau[3][0];
          // requête qui permet de récuperer pire rang d'un adhérent des éditions de la course sélectionnée

          $tableauRequete [6]=array(); // l'indice 6 du tableau de requête devient un tableau sous requêtes
          $tableauRequete[6][0] = 'SELECT MIN(rang) FROM Resultat R JOIN Adherent A ON A.prenom =R.prenom AND R.nom = A.nom WHERE idEdition ='.$value["idEdition"].' AND idE = '.$tableau[1][0];
          $tableauRequete[6][1] = 'SELECT MIN(rang) FROM Resultat R JOIN Adherent A ON A.prenom =R.prenom AND R.nom = A.nom WHERE idEdition ='.$value["idEdition"].' AND idE = '.$tableau[2][0];
          $tableauRequete[6][2] = 'SELECT MIN(rang) FROM Resultat R JOIN Adherent A ON A.prenom =R.prenom AND R.nom = A.nom WHERE idEdition ='.$value["idEdition"].' AND idE = '.$tableau[3][0];
          // requête qui permet de récuperer meilleur rang d'un adhérent des éditions de la course sélectionnée

          $tableauRequete[7]=array(); // l'indice 7 du tableau de requête devient un tableau sous requêtes
          $tableauRequete[7][0] = 'SELECT AVG(T.temps) FROM TempsPassage T JOIN Resultat R ON R.dossard = T.dossard AND R.idEdition = T.idEdition AND R.idE = T.idE JOIN Adherent A ON R.nom = A.nom AND R.prenom = A.prenom WHERE R.idEdition='.$value["idEdition"].' AND R.idE = '.$tableau[1][0].' AND T.km=41';
          $tableauRequete[7][1] = 'SELECT AVG(T.temps) FROM TempsPassage T JOIN Resultat R ON R.dossard = T.dossard AND R.idEdition = T.idEdition AND R.idE = T.idE JOIN Adherent A ON R.nom = A.nom AND R.prenom = A.prenom WHERE R.idEdition='.$value["idEdition"].' AND R.idE = '.$tableau[2][0].' AND T.km=21';
          $tableauRequete[7][2] = 'SELECT AVG(T.temps) FROM TempsPassage T JOIN Resultat R ON R.dossard = T.dossard AND R.idEdition = T.idEdition AND R.idE = T.idE JOIN Adherent A ON R.nom = A.nom AND R.prenom = A.prenom WHERE R.idEdition='.$value["idEdition"].' AND R.idE = '.$tableau[3][0].' AND T.km=10';
          // requête qui permet de récuperer la moyenne des temps réalisés par les adhérents de l’association

          $tableauRequete[8]=array(); // l'indice 8 du tableau de requête devient un tableau sous requêtes
          $tableauRequete[8][0] = 'SELECT DISTINCT COUNT(*) FROM Resultat R JOIN Adherent A ON A.nom=R.nom AND R.prenom=A.prenom WHERE R.rang IS NULL AND R.idEdition='.$value["idEdition"].' AND R.idE = '.$tableau[1][0];
          $tableauRequete[8][1] = 'SELECT DISTINCT COUNT(*) FROM Resultat R JOIN Adherent A ON A.nom=R.nom AND R.prenom=A.prenom WHERE R.rang IS NULL AND R.idEdition='.$value["idEdition"].' AND R.idE = '.$tableau[2][0];
          $tableauRequete[8][2] = 'SELECT DISTINCT COUNT(*) FROM Resultat R JOIN Adherent A ON A.nom=R.nom AND R.prenom=A.prenom WHERE R.rang IS NULL AND R.idEdition='.$value["idEdition"].' AND R.idE = '.$tableau[3][0];
          // requête qui permet de récuperer le nombre d'abandons fait par les adhérents de l’association

          $resultatRequete=array (); // crée un tableau pour les résultats des requêtes

          foreach ($tableauRequete as $key => $value) { // boucle qui permet de parcourir le tableau de requête
            if ($key!=0 AND $key!=1 AND $key !=2){ // si il y a des sous requêtes au tableau de requête
              $resultatRequete [$key]=array (); // l'indice ($key) devient un tableau de résultat pour les sous-requêtes
              foreach ($value as $key2 => $value2) { // boucle qui permet de parcourir le tableau de sous-requêtes
                $resultatRequete [$key][$key2]=traiterRequete ($value2);
              }
            }
            else { // si il n'y a pas de sous-requête
              $resultatRequete [$key]=traiterRequete ($value);
            }
          }
          //exécute les requêtes

          $affichage='<table class="table table-bordered table-dark "><tr><td>Nombre total  d’adhérents ayant couru l’édition</td><td>Nombre total  d’adhérents ayant couru l’édition en tant que licencié dans un club d’athlétisme</td>';
          $affichage.='<td class="cols-3">Nombre de clubs d’athlétisme représentés durant l’édition de la course</td><td>Temps du vainqueur de l’édition</td><td>Pire temps pour un adhérent</td><td>Pire rang pour un adhérent</td>';
          $affichage.='<td>Meilleur rang pour un adhérent</td><td>Moyenne des temps réalisée par les adhérents</td><td>Nombre d’abandons</td></tr>';
          $affichage.='<tr><td>41 km:'.$resultatRequete[0][1][0].'<br/>21 km:'.$resultatRequete[0][2][0].'<br/>10 km:'.$resultatRequete[0][3][0].'</td><td>41 km:'.$resultatRequete[1][1][0].'<br/> 21 km :'.$resultatRequete[1][2][0].' <br/> 10 km: '.$resultatRequete[1][3][0].'</td><td>'.$resultatRequete[2][1][0].'</td><td>41 km: '.$resultatRequete[3][0][1][0].'min<br/>21 km: '.$resultatRequete[3][1][1][0].'min<br/>10 km: '.$resultatRequete[3][2][1][0].'min</td>';
          $affichage.='<td>41 km: '.$resultatRequete[4][0][1][0].'min<br/>21 km: '.$resultatRequete[4][1][1][0].'min<br/>10 km: '.$resultatRequete[4][2][1][0].'min</td>';
          $affichage.='<td>41 km: '.$resultatRequete[5][0][1][0].'<br/>21 km: '.$resultatRequete[5][1][1][0].'<br/>10 km: '.$resultatRequete[5][2][1][0].'</td>';
          $affichage.='<td>41 km: '.$resultatRequete[6][0][1][0].'<br/>21 km: '.$resultatRequete[6][1][1][0].'<br/>10 km: '.$resultatRequete[6][2][1][0].'</td>';
          $affichage.='<td>41 km: '.$resultatRequete[7][0][1][0].'min<br/>21 km: '.$resultatRequete[7][1][1][0].'min<br/>10 km: '.$resultatRequete[7][2][1][0].'min</td>';
          $affichage.='<td>41 km: '.$resultatRequete[8][0][1][0].'<br/>21 km: '.$resultatRequete[8][1][1][0].'<br/>10 km: '.$resultatRequete[8][2][1][0].'</td></tr></table>';
          print ($affichage);
          //affiche un tableau pour chaque édition de la course sélectionnée contenant toutes les informaions relatives à l'édition
        }
        else print ('Il n’y a pas d’information sur l’édition.');
      }
    }
    $requete='SELECT idC FROM Course WHERE nom="'.$courseSelectionnee.'"';
    //requête qui permet de récuperer l'idC de la course sélectionnée
    $tableauRequete=traiterRequete($requete);
    $idC=$tableauRequete[1]["idC"];
?>
    <form method="post" action="espacePerso.php">
      <input type="submit" value="Supprimer course" class="btn btn-outline-warning col-6 offset-3" name="Supprimer_course">
      <input type="hidden" value="<?php print ($tableauRequete[1]["idC"]) ?>" name="supCourseCache">
      <!-- input de type caché qui permet d'envoyer le nom de la course à supprimer -->
    </form>
    <!-- formulaire qui permet de supprimer une course -->
    <form method="post" action="espacePerso.php">
      <input type="submit" name="modifier_course"  class="btn btn-outline-danger col-6 offset-3" value="Modifier course">
      <input type="hidden" name="modifier_course_cache" value="<?php print ($courseSelectionnee) ?>">
      <!-- input de type caché qui permet d'envoyer le nom de la course à modifier -->
    </form>
    <!-- formulaire qui permet de modifier une course -->

    <form method="post" action="espacePerso.php">
      <input type="hidden" value="<?php print($courseSelectionnee) ?>" name="Ajouter_edition_cache">
      <!-- input de type caché qui permet d'envoyer le nom de la course à laquelle ajouter une édition -->
      <input type="submit" value="Ajouter une édition à la course" class="btn btn-outline-danger col-6 offset-3" name="Ajouter_edition">
    </form>
    <!-- formulaire qui permet d'ajouter une édition à la course sélectionnée -->

    <form method="post" action="espacePerso.php">
      <input type="submit" class="form-control btn btn-outline-primary col-6 offset-3" value="Ajouter une course"  name="Ajouter_course">
    </form>
    <!-- formulaire qui permet d'ajouter une course-->
<?php
  }
  if (isset ($_POST["Ajouter_course"])){ // si l'utilisateur veut ajouter une course
?>
    <form method="post" action="espacePerso.php">
      <p>
       <fieldset>
         <legend> Information sur la course </legend>
         <label for="Nom"> Nom de la course :</label>
         <input type="text" name="Nom" required />
         <br />
         <label for="Annee_creation">Année de création de la course :</label>
         <input type="text" name="AnneeCreation" required/>
         <br/>
         <label for="Mois">Mois de la course :</label>
         <input type="text" name="Mois" required />
         <br/>
         <input type="hidden" name="Ajouter_course">
         <input type="submit" name="pValiderCourse" class="btn btn-outline-light" value="Valider">
      </p>
        </fieldset>
    </form>
    <!-- formulaire qui ajoute une course-->
  <?php
  }

  if (isset ($_POST["Ajouter_edition"])){ // si l'utilisateur veut ajouter une édition
    ?>
    <form method="post" action="espacePerso.php">
      <p>
       <fieldset>
         <legend> Information sur l'édition </legend>
         <label for="annee"> Annee de l'édition</label>
         <input type="text" name="annee" required />
         <br />
         <label for="nbParticipant">Nombre de participants :</label>
         <input type="text" name="nbParticipant" required/>
         <br/>
         <label for="adresseDepart">Adresse de départ :</label>
         <input type="text" name="adresseDepart" required />
         <br/>
         <label for="dateInscription">Date de l'inscription :</label>
         <input type="text" name="dateInscription" required />
         <br/>
         <label for="dateDepotCertificat">Date de dépôt du certificat :</label>
         <input type="text" name="dateDepotCertificat" required />
         <br/>
         <label for="dateRecupDossard">Date de récupération des dossards :</label>
         <input type="text" name="dateRecupDossard" required />
         <br/>
         <label for="url">url du site :</label>
         <input type="text" name="url" required />
         <br/>
         <input type="hidden" name="valider_ajout_edition_cache" value="<?php print ($_POST["Ajouter_edition_cache"]); ?>">
         <!-- input type cache qui permet d'envoyer l'idC de la course sélectionné -->
         <input type="submit" name="valider_ajout_edition" class = "btn btn-outline-light" value="Valider">
      </p>
        </fieldset>
    </form>
    <!-- formulaire qui ajoute une édition à la course sélectionnée-->
  <?php } ?>
