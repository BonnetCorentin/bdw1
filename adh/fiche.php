<?php
if (!isset ($_SESSION))session_start (); // regarde si une session est deja en cours

  if (!isset ($tableau[1])) require_once('../connexionBD.php'); // si il ne s'agit pas d'un include, mais que dans l'url c'est bien adh/fiche.php, alors inclus les fonctions php en revenant d'un cran derriere dans les fichiers
  $requete = "SELECT idA FROM Utilisateur WHERE pseudo = '".$_SESSION["slogin"]."'"; // requete pour selectionner l'idA de l'adherent en question
  $tableauu=traiterRequete($requete);
  $ida = $tableauu[1]["idA"];
  if ( $tableauu[1]["idA"] == NULL){ // regarde s'il sagit d'un nouvel utilisateur
    if (isset($_POST['pValiderr'])){ // si il s'agit dans un nouvel adherent et qu'il a clique sur valide, envoie les nouvelles informations dans la base de donnée
      $requete ="INSERT INTO Adherent (nom, prenom, date_naissance, sexe, adresse, date_validite_certificat, nom_club) VALUES ('".$_POST["nom"]."','".$_POST["prenom"]."','".$_POST["date"]."','".$_POST["sexe"]."','".$_POST["adresse"]."','".$_POST["date_certificat"]."','".$_POST["club"]."')";
      modifierLaTable($requete);
      $requete2 ="SELECT idA FROM Adherent WHERE nom = '".$_POST["nom"]."' AND prenom = '".$_POST["prenom"]."'";
      $tableauIda = traiterRequete($requete2);
      $idA = $tableauIda[1][0];
      $requete = "UPDATE Utilisateur SET idA = $idA WHERE pseudo = '".$_SESSION["slogin"]."' ";
      modifierLaTable($requete);
    }
  }
  else if (isset($_POST['pValiderr'])) { // si l'adherent n'est pas nouveau
    $requete = "UPDATE Adherent SET nom = '".$_POST["nom"]."', prenom = '".$_POST["prenom"]."', date_naissance = '".$_POST["date"]."', sexe = '".$_POST["sexe"]."', adresse = '".$_POST["adresse"]."' , date_validite_certificat = '".$_POST["date_certificat"]."', nom_club = '".$_POST["club"]."' WHERE idA = '".$tableauu[1]["idA"]."'";
    modifierLaTable($requete); // met a jour les données de l'Utilisateur via la requete
  }
  else { // si aucun bouton n'est selectionne et qu'il ne s'agit pas d'un nouvel utilisateur, recupere les données deja enregistres
    $requete = "SELECT nom,prenom,date_naissance,sexe,adresse,date_validite_certificat,nom_club FROM Adherent WHERE idA = '".$ida."' "; // recupere informations de l'adherent
    $tableauRetourne = traiterRequete($requete);
    $_POST["nom"] = $tableauRetourne[1]['nom'];
    $_POST["date"] = $tableauRetourne[1]['date_naissance'];
    $_POST["sexe"] = $tableauRetourne[1]['sexe'];
    $_POST["adresse"] = $tableauRetourne[1]['adresse'];
    $_POST["date_certificat"] = $tableauRetourne[1]['date_validite_certificat'];
    $_POST["club"] = $tableauRetourne[1]['nom_club'];
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <link rel="stylesheet" type="text/css" href= "<?php if (!isset ($tableau[1])) print "../css/bootstrap/bootstrap.css"; else print "css/bootstrap/bootstrap.css";?>"media="all"/>  <!-- En fonction de l'ou on se situe, inclus le css avec un chemin different-->
    <title>La Grammondsion</title>
  </head>
  <body class="p-3 mb-2 bg-dark text-white">
    <h1>Profil adhérent de <?php print $_SESSION ["slogin"]; ?> </h1>
      <p>
        <div class="form-row">
          <form method="post"  name= "fiche" action="<?php if (isset ($tableau[1])) print "espacePerso.php"; else print "../espacePerso.php";?>" >
            <p>
              <fieldset>
                <legend> Vos informations </legend>
                <label for="Nom"> Votre nom :</label>
                <input type="text"  name="nom" value = "<?php if (isset ($_POST["nom"]))  print $_POST["nom"] ; ?>" required />  <!-- Si l'adherent n'est pas nouveau rentre deja ses informations, sinon ne met rien-->
                <br />
                <label for="Prenom">Votre prénom :</label>
                <input type="text" name="prenom" value= "<?php print $_SESSION["slogin"]; ?>"  required/>  <!-- Required car il est oblige de les rentrer-->
                <br/>
                <label for="Naissance">Votre date de naissance :</label>
                <input type="text" name="date" placeholder="Du type 00/00/2000" value= "<?php if (isset ($_POST["date"]))  print $_POST["date"] ; ?>"  required />
                <br/>
                <label for="Sexe">Votre Sexe :</label>
                <input type="text" name="sexe" placeholder="H ou F" value= "<?php if (isset ($_POST["sexe"]))  print $_POST["sexe"] ; ?>" required/>
                <br/>
                <label for="Adresse">Votre adresse :</label>
                <input type="text" name="adresse" value= "<?php if (isset ($_POST["adresse"]))  print $_POST["adresse"] ; ?>" required/>
                <br/>
                <label for="Date_Certificat">Votre date de validité du certificat :</label>
                <input type="text" name="date_certificat" placeholder="Du type 00/00/2000"  value= "<?php if (isset ($_POST["date_certificat"]))  print $_POST["date_certificat"] ; ?>" required />
                <br/>
                <label for="Club"> Votre club :</label>
                <input type ="text" name ="club" placeholder="ClubLyon ou ClubParis" value = "<?php if (isset ($_POST["club"]))  print $_POST["club"] ; ?>"  required />
                <br/>
                <input class="btn btn-outline-info" type="submit" name="pValiderr" value="Valider">
                <a <?php if (isset($_POST['pValiderr'])) print "href='espacePerso.php' role='button'>Confirmer"; ?></a></br>
              </p>
            </fieldset>
          </form>
        </div>
      </p>
  </body>
</html>
