<?php
  if (!isset ($_SESSION)) // si une session n'est pas en cours en démarre une
  session_start ();
  require_once ('connexionBD.php');
  if (isset ($_POST["modifier_edition"])){ // si l'utilisateur veut modifier l'édition de la course
    $requete='SELECT annee,nbParticipant,adresseDepart,dateInscription,dateDepotCertificat,dateRecupDossard,url FROM Edition WHERE idEdition="'.$_POST["modifCache"].'"';
    // requête qui permet de récupérer les informations de l'éditions à modifier
    $tableauRequete=traiterRequete ($requete);
  }
  if (isset ($_POST["modifier_course"])){ // si l'utilisateur veut modifier une course
    $requete='SELECT anneeCreation,mois FROM Course WHERE nom="'.$_POST["modifier_course_cache"].'"';
    // requête qui permet de récupérer les informations sur la course à modifier
    $tableauRequete=traiterRequete ($requete);
  }
  if (isset ($_POST["valider_modification_edition"])){ // si l'utilisateur a modifé l'édition de la course
    $requete = 'UPDATE Edition SET annee = "'.$_POST["annee"].'", nbParticipant = "'.$_POST["nbParticipant"].'",  adresseDepart= "'.$_POST["adresseDepart"].'", dateInscription = "'.$_POST["dateInscription"].'", dateDepotCertificat = "'.$_POST["dateDepotCertificat"].'", dateRecupDossard ="'.$_POST["dateRecupDossard"].'" , url = "'.$_POST["url"].'"';
    // requête qui permet de modifier dans la base de donnée l'édition de la course
    modifierLaTable($requete);
  }
  if (isset ($_POST["valider_modification_course"])){ // si l'utilisateur a modifé la course
    $requete = 'UPDATE Course SET anneeCreation = "'.$_POST["anneeCreation"].'", mois = "'.$_POST["mois"].'"';
    // requête qui permet de modifier dans la base de donnée la course
    modifierLaTable($requete);
  }

if (isset ($_POST["modifier_edition"])){ // si l'utilisateur veut modifier la édition
?>
  <form method="post" action="espacePerso.php">
  <p>
    <fieldset>
      <legend>Information sur l'édition </legend>
      <label for="annee">Année :</label>
      <input type="text"  name="annee" value="<?php print($tableauRequete[1]["annee"]); ?>"required />
      <br />
      <label for="nbParticipant">Nombre de participant :</label>
      <input type="text" name="nbParticipant" value="<?php print($tableauRequete[1]["nbParticipant"]); ?>"required/>
      <br/>
      <label for="adresseDepart">Adresse de départ :</label>
      <input type="text" name="adresseDepart" value="<?php print($tableauRequete[1]["adresseDepart"]); ?>"  required />
      <br/>
      <label for="dateInscription">Date des inscriptions :</label>
      <input type="text" name="dateInscription" placeholder="Du type 00/00/2000" value="<?php print($tableauRequete[1]["dateInscription"]); ?>" required/>
      <br/>
      <label for="dateDepotCertificat">Date du dépôt des certificats :</label>
      <input type="text" name="dateDepotCertificat" placeholder="Du type 00/00/2000" value="<?php print($tableauRequete[1]["dateDepotCertificat"]); ?>" required/>
      <br/>
      <label for="dateRecupDossard">Date de récupération des dossards :</label>
      <input type="text" name="dateRecupDossard" placeholder="Du type 00/00/2000" value="<?php print($tableauRequete[1]["dateRecupDossard"]); ?>" required />
      <br/>
      <label for="url">URL :</label>
      <input type ="text" name ="url" value="<?php print($tableauRequete[1]["url"]); ?>" required />
      <br/>
      <input  type="submit" name="valider_modification_edition"  class="btn btn-outline-light" value="Valider">
  </p>
  </form>
  <!-- formulaire qui modifie l'édition de la course-->
<?php
}

if (isset ($_POST["modifier_course"])){ // si l'utilisateur veut modifer la course
?>
  <form method="post" action="espacePerso.php">
  <p>
    <fieldset>
      <legend>Information sur la course </legend>
      <label for="anneeCreation">Année de création :</label>
      <input type="text" name="anneeCreation" value="<?php print($tableauRequete[1]["anneeCreation"]); ?>"required/>
      <br/>
      <label for="mois">Mois :</label>
      <input type="text" name="mois" value="<?php print($tableauRequete[1]["mois"]); ?>"  required />
      <br/>
      <input  type="submit" name="valider_modification_course" class="btn btn-outline-light" value="Valider">
  </p>
  </form>
  <!-- formulaire qui modifie une course-->
<?php
}
?>
