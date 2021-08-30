<?php
  if (!isset ($_SESSION)) // si une session n'est pas en cours en démarrer une
  session_start ();

  if (isset ($_POST["liste_utilisateur"])){ // si l'utilisateur veut voir la liste des utilisateurs
    $requete='SELECT pseudo,mot_de_passe FROM Utilisateur WHERE role!="Administrateur"';
    // requête qui permet de récupérer informations sur les utilisateurs qui ne sont pas administrateur
    $tableauRequete=traiterRequete ($requete);
    $affichage='<table class="table table-striped table-dark"<tr><td>Pseudo</td><td>Mot de passe</td><td>Modifier</td><td>Supprimer</td></tr>';
    foreach ($tableauRequete as $key => $value) { // boucle qui permet de parcourir le tableau résultant de la requête
      if($key!=0){ // si la ligne du tableau est différente de l'entête
        $affichage.='<tr><td>'.$value["pseudo"].'</td><td>'.$value["mot_de_passe"].'</td><td><form method="post" action="espacePerso.php"><input type="hidden" name="modifier_utilisateur_cache" value="'.$value["pseudo"].'"><input type="submit" class="btn btn-outline-light" name="modifier_utilisateur" value="Modifier"></td><td>';
        $affichage.='<form method="post" action="espacePerso.php"><input type="hidden" name="supprimer_utilisateur_cache" value="'.$value["pseudo"].'"><input type="submit" class="btn btn-outline-light" name="supprimer_utilisateur" value="Supprimer"></tr>';
      }
    }
    $affichage.='</table>';
    print ($affichage);
    // affiche la liste des utilisateurs avec un bouton pour modifier ou supprimer l'utilisateur et un input de type hidden pour envoyer l'utilisateur sélectionné
    $affichage='<form method="post" action="espacePerso.php"><input type="submit" name="ajouter_utilisateur"  class="btn btn-dark btn-outline-primary col-6 offset-3" value="Ajouter un utilisateur"></form>';
    print ($affichage);
    // formulaire qui permet d'ajouter un utilisateur
  }
  if (isset ($_POST["supprimer_utilisateur"])){ // si l'utilisateur a supprimé un utilisateur
    $requete='DELETE FROM Utilisateur WHERE pseudo="'.$_POST["supprimer_utilisateur_cache"].'"';
    // requête qui permet supprimer un utilisateur de la base de donnée
    modifierLaTable ($requete);
  }
  if (isset ($_POST["valider_modification_utilisateur"])){ // si l'utilisateur a modifé un utilisateur
    $requete = 'UPDATE Utilisateur SET pseudo = "'.$_POST["pseudo"].'", mot_de_passe = "'.$_POST["mot_de_passe"].'" WHERE pseudo="'.$_POST["valider_modification_utilisateur_cache"].'"';
    // requête qui permet de modifier un utilisateur de la base de donnée
    modifierLaTable($requete);
  }
  if (isset ($_POST["valider_ajout_utilisateur"])){ // si l'utilisateur a ajouté un utilisateur
    $requete ='INSERT INTO Utilisateur (pseudo, mot_de_passe,role) VALUES ("'.$_POST["pseudo"].'","'.$_POST["mot_de_passe"].'","adherent")';
    // requête qui permet d'ajouter un utilisateur à la base de donnée
    modifierLaTable ($requete);
  }
  if (isset ($_POST["modifier_utilisateur"])){ // si l'utilisateur veut modifier un utilisateur
    $requete='SELECT pseudo,mot_de_passe FROM Utilisateur WHERE pseudo="'.$_POST["modifier_utilisateur_cache"].'"';
    // requête qui permet de récupérer les informations de l'utilisateur a modifier
    $tableauRequete=traiterRequete ($requete);
    ?>
      <form method="post" action="espacePerso.php">
      <p>
        <fieldset>
          <legend>Information sur l'utilisateur </legend>
          <label for="pseudi">Pseudo :</label>
          <input type="text"  name="pseudo" value="<?php print($tableauRequete[1]["pseudo"]); ?>"required />
          <br />
          <label for="mot_de_passe">Mot de passe :</label>
          <input type="text" name="mot_de_passe" value="<?php print($tableauRequete[1]["mot_de_passe"]); ?>"required/>
          <br/>
          <input type="hidden" name="valider_modification_utilisateur_cache" value="<?php print ($tableauRequete[1]["pseudo"]) ?>">
           <!-- input type hidden qui permet d'envoyer le psuedo de l'utilisateur à modifier -->
          <input class="btn btn-outline-info" type="submit" name="valider_modification_utilisateur" value="Valider">
      </p>
      </form>
      <!-- formulaire qui modifie un utilisateur-->
<?php
  }
  if (isset ($_POST["ajouter_utilisateur"])){ // si l'utilisateur veut ajouter un utilisateur
?>
    <form method="post" action="espacePerso.php">
    <p>
      <fieldset>
        <legend>Information sur l'utilisateur </legend>
        <label for="pseudi">Pseudo :</label>
        <input type="text"  name="pseudo" required />
        <br />
        <label for="mot_de_passe">Mot de passe :</label>
        <input type="text" name="mot_de_passe" required/>
        <br/>
        <input type="hidden" name="valider_modification_utilisateur_cache">
        <input class="btn btn-outline-info" type="submit" name="valider_ajout_utilisateur" value="Valider">
    </p>
    </form>
    <!-- formulaire qui ajoute un utilisateur-->
<?php
  }
?>
