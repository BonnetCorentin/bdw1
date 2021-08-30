<?php
  if (!isset ($_SESSION)) // si une session n'est pas en cours en démarre une
  session_start ();
  require_once ('connexionBD.php');
  if (isset ($_POST ["voir_adherent"])){ //si l'utilisateur veut voir la liste des adhérents
    $requete='SELECT * FROM Adherent ';
    // requête qui permet de récuperer toutes les informations sur les adhérents
    $tableauRequete=traiterRequete ($requete);
    $affichage='<table class="table table-striped table-dark"><tr><td>Id adhérent</td><td>Nom</td><td>Prenom</td><td>Date de naissancance</td><td>Sexe</td><td>Adresse</td><td>Date validité du certificat</td><td>Nom du club</td><td>Modifier adhérent</td><td>Supprimer adhérent</td></tr>';
    foreach ($tableauRequete as $key => $value) { // boucle qui permet de parcourir le tableau résultant de la requête
      if ($key !=0){ // si la ligne du tableau est différente de l'entête
        $affichage.='<tr><td>'.$value["idA"].'</td><td>'.$value["nom"].'</td><td>'.$value["prenom"].'</td><td>'.$value["date_naissance"].'</td><td>'.$value["sexe"].'</td><td>'.$value["adresse"].'</td><td>'.$value["date_validite_certificat"].'</td><td>'.$value["nom_club"].'</td>';
        $affichage.='<td><form method="post" action="espacePerso.php"><input type="hidden" name="modifier_cache" value="'.$value["idA"].'"><input type="submit" class="btn btn-outline-light" name="modifier_adherent" value="Modifier"></td></form>';
        $affichage.='<td><form method="post" action="espacePerso.php"><input type="hidden" name="supprimer_adherent" value="'.$value["idA"].'"><input type="submit" class="btn btn-outline-light" name= "Supprimer" value="Supprimer"></form></tr>';
      }
    }
    $affichage.='</table>';
    print ($affichage);
    // affiche la liste des adhérents avec un bouton pour modifier ou supprimer l'adhérent et un input de type hidden pour envoyer l'adhérent sélectionné
  }
  if (isset($_POST ["supprimer_adherent"])){ // si l'utilisateur a supprimé adhérent
    $requete='DELETE FROM Adherent WHERE idA="'.$_POST["supprimer_adherent"].'"';
    // requête qui permet de supprimer de la base de donnée l'adhérent
    modifierLaTable ($requete);
  }
  if (isset($_POST ["valider_ajout_adherent"])){ // si l'utilisateur a ajouté adhérent
    $requete ="INSERT INTO Adherent (nom, prenom, date_naissance, sexe, adresse, date_validite_certificat, nom_club) VALUES ('".$_POST["nom"]."','".$_POST["prenom"]."','".$_POST["date"]."','".$_POST["sexe"]."','".$_POST["adresse"]."','".$_POST["date_certificat"]."','".$_POST["club"]."')";
    // requête qui permet d'insérer un adhérent dans la base de donnée
    modifierLaTable ($requete);
  }
  if (isset($_POST["ajouter_adherent"])){ // si l'utilisateur veut ajouter un adhérent
    ?>
    <form method="post" action="espacePerso.php">
    <p>
      <fieldset>
        <legend>Information </legend>
        <label for="Nom">Nom :</label>
        <input type="text"  name="nom" required />
        <br />
        <label for="Prenom">Prénom :</label>
        <input type="text" name="prenom" required/>
        <br/>
        <label for="Naissance">Date de naissance :</label>
        <input type="text" name="date" placeholder="Du type 00/00/2000"  required />
        <br/>
        <label for="Sexe">Sexe :</label>
        <input type="text" name="sexe" placeholder="H ou F" required/>
        <br/>
        <label for="Adresse">Adresse :</label>
        <input type="text" name="adresse" required/>
        <br/>
        <label for="Date_Certificat">Date de validité du certificat :</label>
        <input type="text" name="date_certificat" placeholder="Du type 00/00/2000" required />
        <br/>
        <label for="Club">Club :</label>
        <input type ="text" name ="club" placeholder="ClubLyon ou ClubParis" required />
        <br/>
        <input class="btn btn-outline-info" type="submit" name="valider_ajout_adherent" value="Valider">
    </p>
  </form>
  <!-- formulaire qui ajoute un adhérent-->
<?php
  }
?>

  <form method="post" action="espacePerso.php">
    <input type="submit" name="ajouter_adherent" class="btn btn-outline-primary col-6 offset-3" value="Ajouter un adhérent" class="form-control col-3 mx-auto">
  </form>
  <!-- formulaire qui permet ajoute un adhérent-->
